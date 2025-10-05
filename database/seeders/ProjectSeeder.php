<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            [
                'nama_proyek' => 'Project A',
                'keterangan' => 'Project pengembangan sistem',
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addMonths(3),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_proyek' => 'Project B',
                'keterangan' => 'Project maintenance',
                'tanggal_mulai' => now()->addMonth(),
                'tanggal_selesai' => now()->addMonths(4),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
