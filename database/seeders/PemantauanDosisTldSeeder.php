<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Project;
use App\Models\PemantauanDosisTld;
use Carbon\Carbon;

class PemantauanDosisTldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        foreach ($users as $user) {
            foreach ($projects as $project) {
                // Generate data only for period months: March, June, September, December
                foreach ([3, 6, 9, 12] as $month) {
                    PemantauanDosisTld::create([
                        'project_id' => $project->id,
                        'user_id' => $user->id,
                        'dosis' => rand(1000, 20000), // Random dose
                        'tanggal_pemantauan' => Carbon::create(2024, $month, 1, 0, 0, 0, 'Asia/Jakarta')->format('Y-m-d'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
