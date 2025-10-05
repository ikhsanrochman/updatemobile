<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PemantauanDosisPendose;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;

class PemantauanDosisPendoseSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();
        $jenisAlat = ['TLD', 'Film Badge', 'Pocket Dosimeter', 'Electronic Personal Dosimeter'];

        foreach ($users as $user) {
            foreach ($projects as $project) {
                // Generate data for each month in 2024
                for ($month = 1; $month <= 12; $month++) {
                    PemantauanDosisPendose::create([
                        'project_id' => $project->id,
                        'user_id' => $user->id,
                        'npr' => $user->npr,
                        'jenis_alat_pemantauan' => $jenisAlat[array_rand($jenisAlat)],
                        'hasil_pengukuran' => rand(1000, 20000),
                        'tanggal_pengukuran' => Carbon::create(2024, $month, 15), // Set to 15th of each month
                        'kartu_dosis' => rand(0, 1), // Random boolean
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
} 