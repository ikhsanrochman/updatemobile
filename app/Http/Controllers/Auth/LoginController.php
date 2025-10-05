<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// ==========================================
// CONTROLLER UNTUK MENANGANI PROSES LOGIN
// ==========================================
// Controller ini mengatur:
// 1. Proses login user
// 2. Pengecekan username dan password
// 3. Pengarahan user ke halaman yang sesuai
class LoginController extends Controller
{
    // Menggunakan trait AuthenticatesUsers dari Laravel
    // Trait ini berisi fungsi-fungsi bawaan untuk:
    // - Menampilkan form login
    // - Memproses login
    // - Logout
    use AuthenticatesUsers;

    /**
     * Redirect path setelah login.
     * Ini adalah nilai default tapi tidak akan dipakai
     * karena kita menggunakan fungsi authenticated() untuk redirect
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Mengatur middleware (penjaga) untuk LoginController
     * 
     * Aturannya:
     * 1. Halaman login hanya bisa diakses oleh tamu (belum login)
     * 2. Fungsi logout hanya bisa diakses oleh user yang sudah login
     */
    public function __construct()
    {
        // Middleware 'guest': Hanya tamu yang boleh akses login
        $this->middleware('guest')->except('logout');
        // Middleware 'auth': Hanya user login yang boleh logout
        $this->middleware('auth')->only('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ]);
    }

    /**
     * Menentukan field apa yang dipakai untuk login
     * Di sini kita pakai username (bukan email)
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Fungsi yang dijalankan setelah login berhasil
     * 
     * Alur:
     * 1. Cek role_id user
     * 2. Kalau super admin (role_id = 1) → ke dashboard super admin
     * 3. Kalau admin (role_id = 2) → ke dashboard admin
     * 4. Kalau user (role_id = 3) → ke dashboard user
     * 5. Kalau bukan keduanya → logout dan tampilkan error
     */
    protected function authenticated(Request $request, $user)
    {
        // Cek apakah user adalah super admin
        if ($user->role_id == 1) {
            // Arahkan ke dashboard super admin
            return redirect()->intended(route('super_admin.dashboard'));
        }
        // Cek apakah user adalah admin
        elseif ($user->role_id == 2) {
            // Arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        } 
        // Cek apakah user adalah user biasa
        elseif ($user->role_id == 3) {
            // Arahkan ke dashboard user
            return redirect()->intended(route('user.dashboard'));
        }

        // Kalau role tidak dikenal, logout dan tampilkan error
        Auth::logout();
        return redirect('/login')->withErrors([
            'username' => 'Anda tidak memiliki akses.'
        ]);
    }

    /**
     * Ambil semua email superadmin
     */
    public static function getSuperAdminEmails()
    {
        return \App\Models\User::where('role_id', 1)->pluck('email')->toArray();
    }

    /**
     * Ambil semua email superadmin dan admin
     */
    public static function getAdminEmails()
    {
        return \App\Models\User::whereIn('role_id', [1,2])->pluck('email')->toArray();
    }

    /**
     * Ambil email user berdasarkan ID
     */
    public static function getUserEmailById($id)
    {
        return \App\Models\User::where('id', $id)->value('email');
    }

    /**
     * Ambil nama user berdasarkan ID
     */
    public static function getUserNameById($id)
    {
        return \App\Models\User::where('id', $id)->value('nama');
    }
}
