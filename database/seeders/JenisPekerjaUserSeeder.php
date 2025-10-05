<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPekerjaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assign jenis pekerja ke user
        DB::table('jenis_pekerja_user')->insert([
            [
                'user_id' => 1, // superadmin
                'jenis_pekerja_id' => 1, // Operator
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1, // superadmin
                'jenis_pekerja_id' => 2, // Supervisor
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2, // admin
                'jenis_pekerja_id' => 1, // Operator
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3, // user
                'jenis_pekerja_id' => 3, // Teknisi
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3, // user
                'jenis_pekerja_id' => 4, // Ahli K3
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
} 