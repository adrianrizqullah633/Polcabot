<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('organisasi_knowledge');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('question', 'LIKE', "%{$search}%")
                  ->orWhere('answer', 'LIKE', "%{$search}%")
                  ->orWhere('source', 'LIKE', "%{$search}%")
                  ->orWhereRaw("JSON_SEARCH(keywords, 'all', ?) IS NOT NULL", [$search]);
            });
        }

        $datasets = $query->orderBy('created_at', 'desc')->paginate(6);

        return view('admin.organisasi.index', compact('datasets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.organisasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer'   => 'required|string|max:2000',
            'keywords' => 'nullable|string|max:500',
            'source'   => 'required|url|max:500',
        ]);

        // Convert string → JSON array
        $keywords = null;
        if (!empty($validated['keywords'])) {
            $keywordsArray = array_filter(array_map('trim', explode(',', strtolower($validated['keywords']))));
            $keywords = json_encode(array_values($keywordsArray));
        }

        DB::table('organisasi_knowledge')->insert([
            'question'   => $validated['question'],
            'answer'     => $validated['answer'],
            'keywords'   => $keywords,
            'source'     => $validated['source'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.organisasi.index')
                         ->with('success', 'Dataset berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dataset = DB::table('organisasi_knowledge')->where('id', $id)->first();

        if (!$dataset) {
            return redirect()->route('admin.organisasi.index')
                             ->with('error', 'Dataset tidak ditemukan!');
        }

        return view('admin.organisasi.edit', compact('dataset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer'   => 'required|string|max:2000',
            'keywords' => 'nullable|string|max:500',
            'source'   => 'required|url|max:500',
        ]);

        // Convert string → JSON array
        $keywords = null;
        if (!empty($validated['keywords'])) {
            $keywordsArray = array_filter(array_map('trim', explode(',', strtolower($validated['keywords']))));
            $keywords = json_encode(array_values($keywordsArray));
        }

        DB::table('organisasi_knowledge')
            ->where('id', $id)
            ->update([
                'question'   => $validated['question'],
                'answer'     => $validated['answer'],
                'keywords'   => $keywords,
                'source'     => $validated['source'],
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.organisasi.index')
                         ->with('success', 'Dataset berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('organisasi_knowledge')->where('id', $id)->delete();

        return redirect()->route('admin.organisasi.index')
                         ->with('success', 'Dataset berhasil dihapus!');
    }
}
