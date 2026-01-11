<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'role' => 'required|in:user,bot',
            'content' => 'required|string',
        ]);

        Message::create([
            'conversation_id' => $request->conversation_id,
            'role' => $request->role,
            'content' => $request->content,
        ]);

        return response()->json(['success' => true]);
    }
}