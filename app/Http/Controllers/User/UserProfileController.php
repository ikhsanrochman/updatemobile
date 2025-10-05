<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('user.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && \Storage::disk('public')->exists($user->foto_profil)) {
                \Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('img', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

        return redirect()->route('user.profile.index')
            ->with('success', 'Profile berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('user.profile.index')
            ->with('success', 'Password berhasil diubah!');
    }
} 