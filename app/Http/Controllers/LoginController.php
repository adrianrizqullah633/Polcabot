<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('pages.login');
    }

    /**
     * Process login user (PAKAI EMAIL + PASSWORD)
     */
    public function login(Request $request)
    {
        // Validasi input (HANYA email + password)
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // Coba login dengan Auth::attempt (otomatis pakai email + password)
        if (Auth::attempt($credentials, $request->filled('remember'))) {
        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        // 🔴 WAJIB ambil user setelah login
        $user = Auth::user();

        // ✅ Jika admin → dashboard admin
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Login admin berhasil! Selamat datang, ' . $user->username);
        }

        // ✅ Jika user biasa → dashboard / chat
        return redirect()
            ->route('dashboard')
            ->with('success', 'Login berhasil! Selamat datang, ' . $user->username);
        }

        // Jika gagal, kembali dengan error
        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ])->withInput($request->except('password'));
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}