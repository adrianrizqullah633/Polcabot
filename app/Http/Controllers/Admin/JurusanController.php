<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    /**
     * Menampilkan daftar semua dataset organisasi
     * URL: /admin/organisasi
     */
    public function index(Request $request)
    {
        // Ambil input pencarian dari user
        $search = $request->input('search');
        
        // Query ke database
        $query = DB::table('jurusan_knowledge');
        
        // Jika ada pencarian, filter data
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('question', 'LIKE', "%{$search}%")
                  ->orWhere('answer', 'LIKE', "%{$search}%")
                  ->orWhere('source', 'LIKE', "%{$search}%");
            });
        }
        
        // Ambil data dengan pagination (6 data per halaman)
        $datasets = $query->orderBy('created_at', 'desc')->paginate(6);
        
        // Kirim data ke view
        return view('admin.jurusan.index', compact('datasets'));
    }

    /**
     * Menampilkan form untuk menambah dataset baru
     * URL: /admin/organisasi/create
     */
    public function create()
    {
        return view('admin.jurusan.create');
    }

    /**
     * Menyimpan dataset baru ke database
     * URL: POST /admin/organisasi
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:1000',
            'source' => 'required|url|max:500',
        ]);
        
        // Simpan ke database
        DB::table('jurusan_knowledge')->insert([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'source' => $validated['source'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Redirect dengan pesan sukses
        return redirect()->route('admin.jurusan.index')
                         ->with('success', 'Dataset berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk edit dataset
     * URL: /admin/organisasi/{id}/edit
     */
    public function edit($id)
    {
        // Ambil data dari database berdasarkan ID
        $dataset = DB::table('jurusan_knowledge')->where('id', $id)->first();
        
        // Jika data tidak ditemukan
        if (!$dataset) {
            return redirect()->route('admin.jurusan.index')
                           ->with('error', 'Dataset tidak ditemukan!');
        }
        
        // Kirim data ke view
        return view('admin.jurusan.edit', compact('dataset'));
    }

    /**
     * Update dataset di database
     * URL: PUT /admin/organisasi/{id}
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:1000',
            'source' => 'required|url|max:500',
        ]);
        
        // Update data di database
        DB::table('jurusan_knowledge')
            ->where('id', $id)
            ->update([
                'question' => $validated['question'],
                'answer' => $validated['answer'],
                'source' => $validated['source'],
                'updated_at' => now(),
            ]);
        
        // Redirect dengan pesan sukses
        return redirect()->route('admin.jurusan.index')
                         ->with('success', 'Dataset berhasil diupdate!');
    }

    /**
     * Hapus dataset dari database
     * URL: DELETE /admin/organisasi/{id}
     */
    public function destroy($id)
    {
        // Hapus data dari database
        DB::table('jurusan_knowledge')->where('id', $id)->delete();
        
        // Redirect dengan pesan sukses
        return redirect()->route('admin.jurusan.index')
                         ->with('success', 'Dataset berhasil dihapus!');
    }
}