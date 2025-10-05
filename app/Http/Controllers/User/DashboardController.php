<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemantauanDosisTld;
use App\Models\PemantauanDosisPendose;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $allDosisTld = PemantauanDosisTld::where('user_id', $user->id)
                                        ->orderBy('tanggal_pemantauan', 'desc')
                                        ->get();
        $allDosisPendose = PemantauanDosisPendose::where('user_id', $user->id)
                                                ->orderBy('tanggal_pengukuran', 'desc')
                                                ->get();
        $totalDosis = $allDosisTld->sum('dosis') + $allDosisPendose->sum('hasil_pengukuran');
        return view('user.dashboard', compact('totalDosis', 'allDosisTld', 'allDosisPendose'));
    }
} 