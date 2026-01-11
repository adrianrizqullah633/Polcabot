<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\CommonMarkConverter;
use LucianoTonet\GroqLaravel\Facades\Groq;
use App\Models\Conversation;
use Illuminate\Support\Str;

class ChatBotController extends Controller
{
    public function showTraining()
    {
        return view('admin.training');
    }

    public function chat(Request $request)
    {
        Log::info('🚀 NEW IMPROVED MATCHING CODE LOADED');
        
        $userMessage = trim($request->input('message', ''));

        if (!$userMessage) {
            return response()->json(['reply' => 'Pesan tidak boleh kosong.'], 400);
        }

        Log::info('💬 User Question: ' . $userMessage);

        $answer = $this->searchKnowledgeBaseStrict($userMessage);

        if ($answer) {
            Log::info('✅ STRICT KB MATCH FOUND');

            $this->saveChatHistoryIfAuth(
                Auth::id(),
                $userMessage,
                strip_tags($answer['answer'])
            );

            return response()->json([
                'reply' => nl2br(e($answer['answer'])) .
                    "<br><br><small><b>📌 Sumber:</b> " .
                    "<a href='{$answer['source']}' target='_blank'>{$answer['source']}</a></small>",
                'source' => 'knowledge_base'
            ]);
        }

        Log::info('⚠️ No strict KB match, fallback to Groq');

        return $this->callGroq($userMessage);
    }

    /* ==========================================================
     * STRICT KNOWLEDGE BASE SEARCH
     * SEMUA KEYWORD DI DATASET HARUS ADA DI PERTANYAAN USER
     * ========================================================== */
    private function searchKnowledgeBaseStrict(string $userMessage)
    {
        $normalized = $this->normalizeText($userMessage);
        $userKeywords = $this->extractKeywords($normalized);

        Log::info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        Log::info('🔑 User Message: ' . $userMessage);
        Log::info('🔑 Normalized: ' . $normalized);
        Log::info('🔑 User Keywords: [' . implode(', ', $userKeywords) . ']');

        if (empty($userKeywords)) {
            Log::info('❌ No keywords extracted from user message');
            return null;
        }

        $allTables = $this->getKnowledgeTables();
        
        foreach ($allTables as $table) {
            if (!$this->tableExists($table)) {
                Log::info("⚠️ Table {$table} does not exist, skipping...");
                continue;
            }

            $records = DB::table($table)->get();
            Log::info("📋 Checking table: {$table} ({$records->count()} records)");

            foreach ($records as $record) {
                if (!isset($record->keywords) || empty($record->keywords)) {
                    Log::info("⚠️ Record ID {$record->id} has no keywords, skipping...");
                    continue;
                }

                $datasetKeywords = $this->extractKeywords(
                    $this->normalizeText($record->keywords)
                );

                if (empty($datasetKeywords)) {
                    Log::info("⚠️ Record ID {$record->id} has no valid keywords after processing");
                    continue;
                }

                Log::info("─────────────────────────────────────────");
                Log::info("📄 Record ID: {$record->id}");
                Log::info("📝 Question: " . substr($record->question ?? 'N/A', 0, 50) . "...");
                Log::info("🏷️  Dataset Keywords RAW: {$record->keywords}");
                Log::info("🏷️  Dataset Keywords Processed: [" . implode(', ', $datasetKeywords) . "]");

                if ($this->allKeywordsMatch($datasetKeywords, $userKeywords)) {
                    Log::info("✅✅✅ STRICT MATCH FOUND in {$table} ✅✅✅");
                    Log::info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

                    return [
                        'answer' => $record->answer,
                        'source' => $record->source ?? 'Internal Knowledge Base',
                    ];
                }
            }
        }

        Log::info('❌❌❌ No strict match found in any table ❌❌❌');
        Log::info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        return null;
    }

    private function allKeywordsMatch(array $datasetKeywords, array $userKeywords): bool
    {
        Log::info("🔍 Starting STRICT keyword matching...");
        Log::info("   Dataset keywords (" . count($datasetKeywords) . "): " . implode(', ', $datasetKeywords));
        Log::info("   User keywords (" . count($userKeywords) . "): " . implode(', ', $userKeywords));
        
        foreach ($datasetKeywords as $datasetKeyword) {
            $found = false;
            
            foreach ($userKeywords as $userKeyword) {
                if ($this->isSameWord($datasetKeyword, $userKeyword)) {
                    $found = true;
                    Log::info("   ✅ Match found: '{$datasetKeyword}' ↔️ '{$userKeyword}'");
                    break;
                }
            }

            if (!$found) {
                Log::info("   ❌ Missing keyword: '{$datasetKeyword}' NOT FOUND in user message");
                Log::info("   🚫 Match failed - not all keywords present");
                return false;
            }
        }

        Log::info("   ✅✅✅ ALL KEYWORDS MATCHED! ✅✅✅");
        return true;
    }

    private function isSameWord(string $word1, string $word2): bool
    {
        if ($word1 === $word2) {
            return true;
        }

        $minLength = min(strlen($word1), strlen($word2));
        
        if ($minLength >= 5) {
            $checkLength = (int)($minLength * 0.8);
            if (substr($word1, 0, $checkLength) === substr($word2, 0, $checkLength)) {
                return true;
            }
        }

        return false;
    }

    private function getKnowledgeTables(): array
    {
        return [
            'organisasi_knowledge',
            'beasiswa_knowledge',
            'jurusan_knowledge',
            'daftar_knowledge',
            'event_knowledge',
        ];
    }

    /* ==========================================================
     * GROQ FALLBACK
     * ========================================================== */
    private function callGroq($message)
    {
        try {
            $response = Groq::chat()->completions()->create([
                'model' => env('GROQ_MODEL', 'llama-3.1-8b-instant'),
                'messages' => [
                    ['role' => 'system', 'content' => $this->getSystemPrompt()],
                    ['role' => 'user', 'content' => $message],
                ],
                'max_tokens' => 512,
                'temperature' => 0.7,
            ]);

            $text = $response['choices'][0]['message']['content'] ?? null;

            if ($text) {
                $converter = new CommonMarkConverter([
                    'html_input' => 'strip',
                    'allow_unsafe_links' => false,
                ]);

                $this->saveChatHistoryIfAuth(Auth::id(), $message, strip_tags($text));

                return response()->json([
                    'reply' => $converter->convert($text)->getContent(),
                    'source' => 'groq'
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Groq Error: ' . $e->getMessage());
        }

        return response()->json([
            'reply' => $this->getFallbackResponse(),
            'source' => 'fallback'
        ]);
    }

    /* ==========================================================
     * SYSTEM PROMPT MANAGEMENT (EDIT PROMPT FEATURES)
     * ========================================================== */
    public function updatePrompt(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:2000',
        ]);

        try {
            $exists = DB::table('ai_settings')
                ->where('key', 'system_prompt')
                ->exists();

            if ($exists) {
                DB::table('ai_settings')
                    ->where('key', 'system_prompt')
                    ->update([
                        'value' => $request->input('prompt'),
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('ai_settings')->insert([
                    'key' => 'system_prompt',
                    'value' => $request->input('prompt'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Cache::forget('system_prompt');

            return response()->json([
                'success' => true,
                'message' => 'System prompt berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            Log::error('Update Prompt Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui system prompt.'
            ], 500);
        }
    }

    public function getPrompt()
    {
        try {
            $prompt = $this->getSystemPrompt();
            return response()->json([
                'success' => true,
                'prompt' => $prompt
            ]);
        } catch (\Exception $e) {
            Log::error('Get Prompt Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil system prompt.'
            ], 500);
        }
    }

    public function resetPrompt()
    {
        try {
            $defaultPrompt = "Kamu adalah PolCaBot, asisten virtual resmi Politeknik Negeri Batam.

TUGAS:
- Menjawab pertanyaan tentang Polibatam dengan ramah dan informatif
- Fokus pada: akademik, organisasi, jurusan, beasiswa, fasilitas
- Gunakan Bahasa Indonesia yang sopan
- Jika tidak tahu, akui dengan jujur

GAYA:
- Ramah dan membantu
- Singkat dan jelas
- Gunakan emoji secukupnya 😊";

            DB::table('ai_settings')
                ->updateOrInsert(
                    ['key' => 'system_prompt'],
                    [
                        'value' => $defaultPrompt,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );

            Cache::forget('system_prompt');

            return response()->json([
                'success' => true,
                'message' => 'System prompt berhasil direset ke default.',
                'prompt' => $defaultPrompt
            ]);
        } catch (\Exception $e) {
            Log::error('Reset Prompt Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset system prompt.'
            ], 500);
        }
    }

    /* ==========================================================
     * HELPERS
     * ========================================================== */
    private function normalizeText($text)
    {
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', mb_strtolower(trim($text)));
        return $text;
    }

    private function extractKeywords($message)
    {
        $stopwords = [
            'apa','apakah','bagaimana','mengapa','siapa','dimana','kapan','berapa',
            'dan','atau','tetapi','namun','karena','sehingga',
            'yang','di','ke','dari','untuk','dengan','pada','tentang',
            'adalah','ini','itu','tersebut',
            'saya','kamu','dia','mereka','kami','kita',
            'bisa','dapat','akan','sudah','telah','sedang',
            'the','is','are','was','were','what','where','when','how','why',
            'a','an','and','or','but','in','on','at','to','for','of'
        ];

        $words = explode(' ', $message);
        
        $keywords = array_filter($words, function($word) use ($stopwords) {
            return strlen($word) >= 3 && !in_array($word, $stopwords);
        });

        return array_values($keywords);
    }

    private function tableExists($table)
    {
        try {
            DB::table($table)->limit(1)->get();
            return true;
        } catch (\Exception) {
            return false;
        }
    }

    private function getFallbackResponse()
    {
        return "⚠️ Maaf, saya belum menemukan jawaban yang sesuai.<br><br>
        <b>Tips:</b><br>
        • Gunakan kata kunci spesifik<br>
        • Contoh: <i>organisasi olahraga</i>, <i>event kampus</i><br><br>
        Silakan coba pertanyaan lain 😊";
    }

    private function getSystemPrompt()
    {
        return Cache::remember('system_prompt', 3600, function () {
            return DB::table('ai_settings')
                ->where('key', 'system_prompt')
                ->value('value')
                ?? "Kamu adalah PolCaBot, asisten virtual resmi Politeknik Negeri Batam.

TUGAS:
- Menjawab pertanyaan tentang Polibatam dengan ramah dan informatif
- Fokus pada: akademik, organisasi, jurusan, beasiswa, fasilitas
- Gunakan Bahasa Indonesia yang sopan
- Jika tidak tahu, akui dengan jujur

GAYA:
- Ramah dan membantu
- Singkat dan jelas
- Gunakan emoji secukupnya 😊";
        });
    }

    private function saveChatHistoryIfAuth($userId, $message, $reply)
    {
        if (!$userId) return;

        try {
            // 1️⃣ SIMPAN KE conversations (UNTUK SIDEBAR)
            Conversation::create([
                'user_id' => $userId,
                'title' => Str::limit($message, 60),
            ]);

            // 2️⃣ SIMPAN KE chat_history (DETAIL CHAT)
            if ($this->tableExists('chat_history')) {
                DB::table('chat_history')->insert([
                    'user_id' => $userId,
                    'message' => $message,
                    'reply' => $reply,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to save chat history: ' . $e->getMessage());
        }
    }
}