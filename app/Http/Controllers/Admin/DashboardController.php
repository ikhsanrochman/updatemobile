<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PemantauanDosisTld;
use App\Models\PemantauanDosisPendose;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPekerja = User::count(); // Semua user termasuk admin dan superadmin

        $users = User::with(['pemantauanDosisTld', 'pemantauanDosisPendose'])->get();

        $peringatanDosis = $users->map(function ($user) {
            $totalDosisTld = $user->pemantauanDosisTld->sum('dosis');
            $totalDosisPendose = $user->pemantauanDosisPendose->sum('hasil_pengukuran');
            $user->totalDosis = $totalDosisTld + $totalDosisPendose;
            return $user;
        })->filter(function ($user) {
            return $user->totalDosis > 20000; // Ambang batas 20,000 µSv (20 mSv)
        })->sortByDesc('totalDosis');

        return view('admin.dashboard', compact('totalPekerja', 'peringatanDosis'));
    }
} 