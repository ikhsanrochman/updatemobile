<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PemantauanDosisTld;
use App\Models\PemantauanDosisPendose;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\LoginController;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPekerja = User::count(); 

        $users = User::with(['pemantauanDosisTld', 'pemantauanDosisPendose'])->get();

        $peringatanDosis = $users->map(function ($user) {
            $totalDosisTld = $user->pemantauanDosisTld->sum('dosis');
            $totalDosisPendose = $user->pemantauanDosisPendose->sum('hasil_pengukuran');
            $user->totalDosis = $totalDosisTld + $totalDosisPendose;
            return $user;
        })->filter(function ($user) {
            return $user->totalDosis > 20000; 
        })->sortByDesc('totalDosis');

        // Kirim notifikasi email jika ada peringatan
        if ($peringatanDosis->isNotEmpty()) {
            $adminEmails = LoginController::getAdminEmails();

            foreach ($peringatanDosis as $peringatan) {
                $userEmail = $peringatan->email;
                $userName = $peringatan->nama;
                $totalDosisInmSv = number_format($peringatan->totalDosis / 1000, 3);

                // Kirim ke admin/superadmin
                if (!empty($adminEmails)) {
                    Mail::raw("Peringatan: Dosis akumulatif atas nama $userName telah melebihi batas aman, dengan total dosis $totalDosisInmSv mSv.", function($msg) use ($adminEmails, $userName) {
                        $msg->to($adminEmails)
                            ->subject("Peringatan Dosis Tinggi: $userName");
                    });
                }

                // Kirim ke user bersangkutan
                if ($userEmail) {
                    Mail::raw("Peringatan: Total akumulasi dosis Anda sebesar $totalDosisInmSv mSv telah melebihi batas aman. Harap segera melapor ke atasan atau petugas proteksi radiasi.", function($msg) use ($userEmail) {
                        $msg->to($userEmail)
                            ->subject('Peringatan: Dosis Anda Melebihi Batas Aman');
                    });
                }
            }
        }

        return view('super_admin.dashboard', compact('totalPekerja', 'peringatanDosis'));
    }
} 