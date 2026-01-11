<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255|unique:users,username,' . $user->id,
        'password' => 'nullable|confirmed|min:6',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // update username
    $user->username = $request->name;

    // update password jika diisi
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // upload foto
    if ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('profile', 'public');
        $user->profile_photo = basename($path);
    }

    $user->save();

    return back()->with('success', 'Profil berhasil diperbarui');
    }
}