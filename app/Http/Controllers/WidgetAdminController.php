<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WidgetAdminController extends Controller
{
    /**
     * Verify admin code untuk widget (PUBLIC - No Auth)
     */
    public function verifyCode(Request $request)
    {
        Log::info('🔍 Widget verify code request', [
            'ip' => $request->ip(),
            'has_code' => !empty($request->admin_code)
        ]);

        $request->validate([
            'admin_code' => 'required|string',
        ]);

        try {
            $adminCodeHash = $this->getAdminCodeHash();

            Log::info('🔑 Admin code hash retrieved', [
                'hash_exists' => !empty($adminCodeHash),
                'hash_preview' => substr($adminCodeHash, 0, 20) . '...'
            ]);

            if (Hash::check($request->admin_code, $adminCodeHash)) {
                Log::info('✅ Widget admin code verified successfully', [
                    'ip' => $request->ip()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Admin code valid'
                ]);
            }

            Log::warning('❌ Invalid widget admin code attempt', [
                'ip' => $request->ip(),
                'code_length' => strlen($request->admin_code)
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Admin code tidak valid'
            ], 403);

        } catch (\Exception $e) {
            Log::error('❌ Widget verify error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan verifikasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add knowledge dari widget (PUBLIC tapi butuh valid admin code)
     */
    public function addKnowledge(Request $request)
    {
        Log::info('📝 Widget add knowledge request', [
            'ip' => $request->ip(),
            'table' => $request->input('table'),
            'question_length' => strlen($request->input('question', ''))
        ]);

        // Validate request
        try {
            $request->validate([
                'admin_code' => 'required|string',
                'table' => 'required|string|in:organisasi_knowledge,beasiswa_knowledge,jurusan_knowledge,daftar_knowledge,event_knowledge',
                'question' => 'required|string|max:500',
                'keywords' => 'required|string|max:300',
                'answer' => 'required|string|max:2000',
                'source' => 'nullable|string|max:300',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ Validation failed', [
                'errors' => $e->errors()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }

        // Verify admin code
        $adminCodeHash = $this->getAdminCodeHash();
        
        Log::info('🔐 Verifying admin code...', [
            'hash_exists' => !empty($adminCodeHash)
        ]);
        
        if (!Hash::check($request->admin_code, $adminCodeHash)) {
            Log::warning('❌ Admin code verification failed');
            
            return response()->json([
                'success' => false,
                'message' => 'Admin code tidak valid'
            ], 403);
        }

        Log::info('✅ Admin code verified, proceeding to save...');

        try {
            // Check if table exists
            if (!$this->tableExists($request->table)) {
                Log::error('❌ Table not found', [
                    'table' => $request->table
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Tabel ' . $request->table . ' tidak ditemukan'
                ], 404);
            }

            Log::info('📊 Table exists, inserting data...', [
                'table' => $request->table
            ]);

            // Insert data
            $insertData = [
                'question' => $request->question,
                'keywords' => $request->keywords,
                'answer' => $request->answer,
                'source' => $request->source ?? 'Widget Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Log::info('💾 Data to insert', $insertData);

            DB::table($request->table)->insert($insertData);

            Log::info('✅ Knowledge added successfully via widget', [
                'table' => $request->table,
                'question' => $request->question,
                'ip' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dataset berhasil ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Widget Add Knowledge Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan dataset: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Settings page - Return JSON instead of view for now
     */
    public function settings()
    {
        return response()->json([
            'message' => 'Widget settings page (view belum dibuat)',
            'admin_code_exists' => DB::table('widget_settings')->where('key', 'admin_code')->exists()
        ]);
    }

    /**
     * Generate new admin code
     */
    public function generateNewCode(Request $request)
    {
        try {
            $newCode = 'POLCA-' . strtoupper(Str::random(8));
            $hash = Hash::make($newCode);

            Log::info('🔑 Generating new admin code');

            DB::table('widget_settings')->updateOrInsert(
                ['key' => 'admin_code'],
                [
                    'value' => $hash,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            Log::info('✅ New widget admin code generated successfully');

            return response()->json([
                'success' => true,
                'admin_code' => $newCode,
                'message' => 'Admin code baru berhasil di-generate'
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Generate code error', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate admin code: ' . $e->getMessage()
            ], 500);
        }
    }

    /* ==========================================================
     * PRIVATE HELPER METHODS
     * ========================================================== */

    private function getAdminCodeHash()
    {
        Log::info('🔍 Getting admin code hash...');
        
        try {
            $hash = DB::table('widget_settings')
                ->where('key', 'admin_code')
                ->value('value');

            if ($hash) {
                Log::info('✅ Admin code found in database');
                return $hash;
            }
        } catch (\Exception $e) {
            Log::warning('⚠️ Failed to get hash from database', [
                'error' => $e->getMessage()
            ]);
        }

        $envHash = env('WIDGET_ADMIN_CODE_HASH');
        if ($envHash) {
            Log::info('✅ Admin code found in .env');
            return $envHash;
        }

        Log::warning('⚠️ Using default admin code hash (admin123)');
        return '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
    }

    private function tableExists($table)
    {
        try {
            DB::table($table)->limit(1)->get();
            Log::info('✅ Table exists', ['table' => $table]);
            return true;
        } catch (\Exception $e) {
            Log::error('❌ Table does not exist', [
                'table' => $table,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}