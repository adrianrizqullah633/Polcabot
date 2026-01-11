<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $chatHistory = [
            'Ada Organisasi apa saja di Polibatam',
            'Ada jurusan apa saja di Polibatam',
            'Jadwal Perkuliahan kelas pagi',
            'Cara daftar beasiswa Polibatam'
        ];

        $quickActions = [
            ['title' => 'Ada Organisasi apa saja di Polibatam', 'description' => 'Tanya tentang organisasi kemahasiswaan'],
            ['title' => 'Ada jurusan apa saja di Polibatam', 'description' => 'Informasi lengkap program studi'],
            ['title' => 'Jadwal Perkuliahan kelas pagi', 'description' => 'Cek jadwal kuliah harian'],
            ['title' => 'Cara daftar beasiswa Polibatam', 'description' => 'Informasi lengkap beasiswa kampus']
        ];

        return view('pages.dashboard', compact('user', 'chatHistory', 'quickActions'));
    }

    public function startChat(Request $request)
    {
        $chatId = (string) Str::uuid();
        return response()->json(['chat_id' => $chatId]);
    }

    public function chat($chatId)
    {
        return view('pages.chat', ['id' => $chatId]);
    }

    
}
