<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // logika kirim pesan (contoh simpan ke file/log)
        Log::info('Pesan Kontak:', $request->all());

        return redirect()->back()->with('success', 'Pesan Anda telah dikirim!');
    }
}
