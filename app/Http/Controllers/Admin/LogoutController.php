<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        // Logout user dari guard default atau guard admin
        Auth::logout();
        
        // Invalidate session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}