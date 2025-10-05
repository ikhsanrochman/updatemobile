<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KetersediaanSdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create ketersediaan_sdm
        DB::table('ketersediaan_sdm')->insert([
            [
                'project_id' => 1, // Project A
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'project_id' => 2, // Project B
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Assign users to ketersediaan_sdm
        DB::table('ketersediaan_sdm_users')->insert([
            [
                'ketersediaan_sdm_id' => 1, // Project A
                'user_id' => 1, // superadmin
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ketersediaan_sdm_id' => 1, // Project A
                'user_id' => 2, // admin
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ketersediaan_sdm_id' => 2, // Project B
                'user_id' => 2, // admin
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ketersediaan_sdm_id' => 2, // Project B
                'user_id' => 3, // user
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
