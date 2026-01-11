<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Conversation;
use App\Models\ChatMessage;
use App\Models\Organisasi;
use App\Models\Beasiswa;
use App\Models\Jurusan;
use App\Models\Daftar;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        // Hitung total users (semua user atau hanya role 'user')
        $totalUsers = User::where('role', 'user')->count(); // atau User::count() untuk semua user
        
        // Hitung total conversations
        $totalChats = Conversation::count();
        
        // Hitung masing-masing knowledge base
        $organisasi = Organisasi::count();
        $beasiswa = Beasiswa::count();
        $jurusan = Jurusan::count();
        $daftar = Daftar::count();
        
        // Total knowledge base (gabungan semua)
        $totalKnowledgeBase = $organisasi + $beasiswa + $jurusan + $daftar;
        
        // Detail knowledge base untuk ditampilkan
        $knowledgeDetails = [
            'organisasi' => $organisasi,
            'beasiswa' => $beasiswa,
            'jurusan' => $jurusan,
            'daftar' => $daftar
        ];
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalChats',
            'totalKnowledgeBase',
            'knowledgeDetails'
        ));
    }
    
    public function pengguna()
    {
        // Tampilkan halaman pengguna
        $users = User::where('role', 'user')->get(); // atau sesuai kebutuhan
        return view('admin.pengguna', compact('users'));
    }
    
    public function riwayat()
    {
        // Tampilkan riwayat chat
        $conversations = Conversation::with('user')->latest()->get();
        return view('admin.riwayat', compact('conversations'));
    }
    
    public function knowledge()
    {
        // Tampilkan knowledge base
        return view('admin.knowledge');
    }
    
    public function pengaturan()
    {
        // Tampilkan halaman pengaturan
        return view('admin.pengaturan');
    }
}