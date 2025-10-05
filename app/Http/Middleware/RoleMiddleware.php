<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

// ==========================================
// MIDDLEWARE UNTUK CEK ROLE/PERAN PENGGUNA
// ==========================================
// Middleware ini bertugas mengecek apakah user 
// boleh mengakses halaman tertentu atau tidak
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah role user ada di parameter middleware
        \Log::info('RoleMiddleware: User ID: ' . Auth::id() . ', Role: ' . (Auth::user()->role_id ?? 'N/A') . ', Allowed: ' . json_encode($roles));
        if (!in_array(Auth::user()->role_id, $roles)) {
            Auth::logout();
            return redirect('/login')->withErrors(['username' => 'Anda tidak memiliki akses.']);
        }

        return $next($request);
    }
}
