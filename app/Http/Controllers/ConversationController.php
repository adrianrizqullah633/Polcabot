<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ConversationController extends Controller
{
    // Ambil history chat (sidebar)
    public function index()
    {
        return response()->json(
            Conversation::where('user_id', Auth::id())
                ->latest()
                ->limit(20)
                ->get(['id', 'title'])
        );
    }

    // Simpan pertanyaan user ke history
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255'
        ]);

        Conversation::create([
            'user_id' => Auth::id(),
            'title' => Str::limit($request->question, 60)
        ]);

        return response()->json(['success' => true]);
    }

    // (Opsional) Hapus history
    public function destroy($id)
    {
        Conversation::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json(['success' => true]);
    }
}