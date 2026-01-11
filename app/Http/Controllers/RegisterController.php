<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan form register
     */
    public function showRegisterForm()
    {
        return view('pages.register');
    }

    /**
     * Process registrasi user baru
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username sudah terdaftar!',
            'username.min' => 'Username minimal 3 karakter!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Password dan konfirmasi password tidak sama!',
        ]);

        // Buat user baru dengan password ter-hash
        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect ke login (TIDAK auto login)
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }
}