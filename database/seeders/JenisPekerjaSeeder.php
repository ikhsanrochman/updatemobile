<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPekerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_pekerja')->insert([
            [
                'id' => 1,
                'nama' => 'PPR',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'nama' => 'Industri',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'nama' => 'OPR',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'nama' => 'OR',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
