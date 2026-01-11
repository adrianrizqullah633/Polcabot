<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KnowledgeController extends Controller
{
    /**
     * Tambah knowledge base dari widget
     */
    public function addFromWidget(Request $request)
    {
        $request->validate([
            'table' => 'required|in:organisasi_knowledge,beasiswa_knowledge,jurusan_knowledge,daftar_knowledge,event_knowledge',
            'question' => 'required|string|max:500',
            'keywords' => 'required|string|max:300',
            'answer' => 'required|string|max:2000',
            'source' => 'nullable|string|max:300',
        ]);

        try {
            // Check if table exists
            if (!$this->tableExists($request->table)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tabel tidak ditemukan'
                ], 404);
            }

            // Insert data
            DB::table($request->table)->insert([
                'question' => $request->question,
                'keywords' => $request->keywords,
                'answer' => $request->answer,
                'source' => $request->source ?? 'Widget Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('Knowledge added via widget', [
                'table' => $request->table,
                'question' => $request->question,
                'admin_id' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dataset berhasil ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Widget Add Knowledge Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan dataset: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if table exists
     */
    private function tableExists($table)
    {
        try {
            DB::table($table)->limit(1)->get();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}