<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\CommonMark\CommonMarkConverter;
use LucianoTonet\GroqLaravel\Facades\Groq;

class WidgetChatController extends Controller
{
    /**
     * Chat endpoint untuk widget (PUBLIC - No Auth Required)
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = trim($request->input('message'));
        
        Log::info('💬 Widget Chat Request', [
            'message' => $userMessage,
            'ip' => $request->ip()
        ]);

        // Search Knowledge Base
        $answer = $this->searchKnowledgeBaseStrict($userMessage);

        if ($answer) {
            Log::info('✅ KB Match Found');
            
            return response()->json([
                'success' => true,
                'reply' => nl2br(e($answer['answer'])) .
                    "<br><br><small><b>📌 Sumber:</b> " .
                    "<a href='{$answer['source']}' target='_blank'>{$answer['source']}</a></small>",
                'source' => 'knowledge_base'
            ]);
        }

        // Fallback to Groq AI
        Log::info('⚠️ No KB match, using Groq AI');
        return $this->callGroq($userMessage);
    }

    /* ==========================================================
     * KNOWLEDGE BASE SEARCH (COPY dari ChatBotController)
     * ========================================================== */
    private function searchKnowledgeBaseStrict(string $userMessage)
    {
        $normalized = $this->normalizeText($userMessage);
        $userKeywords = $this->extractKeywords($normalized);

        if (empty($userKeywords)) {
            return null;
        }

        $allTables = [
            'organisasi_knowledge',
            'beasiswa_knowledge',
            'jurusan_knowledge',
            'daftar_knowledge',
            'event_knowledge',
        ];
        
        foreach ($allTables as $table) {
            if (!$this->tableExists($table)) continue;

            $records = DB::table($table)->get();

            foreach ($records as $record) {
                if (!isset($record->keywords) || empty($record->keywords)) continue;

                $datasetKeywords = $this->extractKeywords(
                    $this->normalizeText($record->keywords)
                );

                if (empty($datasetKeywords)) continue;

                if ($this->allKeywordsMatch($datasetKeywords, $userKeywords)) {
                    return [
                        'answer' => $record->answer,
                        'source' => $record->source ?? 'Internal Knowledge Base',
                    ];
                }
            }
        }

        return null;
    }

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

                return response()->json([
                    'success' => true,
                    'reply' => $converter->convert($text)->getContent(),
                    'source' => 'groq'
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Widget Groq Error: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'reply' => $this->getFallbackResponse(),
            'source' => 'fallback'
        ]);
    }

    /* ==========================================================
     * HELPER METHODS
     * ========================================================== */
    private function allKeywordsMatch(array $datasetKeywords, array $userKeywords): bool
    {
        foreach ($datasetKeywords as $datasetKeyword) {
            $found = false;
            foreach ($userKeywords as $userKeyword) {
                if ($this->isSameWord($datasetKeyword, $userKeyword)) {
                    $found = true;
                    break;
                }
            }
            if (!$found) return false;
        }
        return true;
    }

    private function isSameWord(string $word1, string $word2): bool
    {
        if ($word1 === $word2) return true;

        $minLength = min(strlen($word1), strlen($word2));
        if ($minLength >= 5) {
            $checkLength = (int)($minLength * 0.8);
            if (substr($word1, 0, $checkLength) === substr($word2, 0, $checkLength)) {
                return true;
            }
        }
        return false;
    }

    private function normalizeText($text)
    {
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        return preg_replace('/\s+/', ' ', mb_strtolower(trim($text)));
    }

    private function extractKeywords($message)
    {
        $stopwords = [
            'apa','apakah','bagaimana','mengapa','siapa','dimana','kapan','berapa',
            'dan','atau','tetapi','namun','karena','sehingga',
            'yang','di','ke','dari','untuk','dengan','pada','tentang',
            'adalah','ini','itu','tersebut','saya','kamu','dia','mereka'
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

    private function getSystemPrompt()
    {
        return DB::table('ai_settings')
            ->where('key', 'system_prompt')
            ->value('value')
            ?? "Kamu adalah PolCaBot, asisten virtual resmi Politeknik Negeri Batam.";
    }

    private function getFallbackResponse()
    {
        return "⚠️ Maaf, saya belum menemukan jawaban yang sesuai.<br><br>
        <b>Tips:</b><br>
        • Gunakan kata kunci spesifik<br>
        • Contoh: <i>organisasi olahraga</i>, <i>event kampus</i><br><br>
        Silakan coba pertanyaan lain 😊";
    }
}