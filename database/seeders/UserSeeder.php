<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\JenisPekerja;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users
        $users = [
            [
                'nama' => 'Teguh Dimas Gandika Putra',
                'email' => 'superadmin@sipemdora.com',
                'role_id' => 1,
                'no_sib' => 'SIB001',
                'berlaku' => '2024-12-31',
                'keahlian' => 'Manajemen Proyek',
                'foto_profil' => 'img/profile.png',
                'username' => 'superadmin',
                'password' => bcrypt('password'),
                'npr' => 'NPR001',
                'is_active' => true,
                'kartu_dosis' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Hery Setyo Utomo',
                'email' => 'admin@sipemdora.com',
                'role_id' => 2,
                'no_sib' => 'SIB002',
                'berlaku' => '2024-12-31',
                'keahlian' => 'Administrasi',
                'foto_profil' => 'img/profile.png',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'npr' => 'NPR002',
                'is_active' => true,
                'kartu_dosis' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Andi Bagus Indra Kusuma',
                'email' => 'user@sipemdora.com',
                'role_id' => 3,
                'no_sib' => 'SIB003',
                'berlaku' => '2024-12-31',
                'keahlian' => 'Teknisi',
                'foto_profil' => 'img/profile.png',
                'username' => 'user',
                'password' => bcrypt('password'),
                'npr' => 'NPR003',
                'is_active' => true,
                'kartu_dosis' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Insert users and get their IDs
        foreach ($users as $userData) {
            $user = User::create($userData);
            
            // Get all jenis pekerja IDs
            $jenisPekerjaIds = JenisPekerja::pluck('id')->toArray();
            
            // Only proceed if there are jenis pekerja available
            if (!empty($jenisPekerjaIds)) {
                // Randomly select 2 jenis pekerja
                // Ensure we don't try to select more unique workers than available
                $numberOfWorkersToSelect = min(2, count($jenisPekerjaIds));
                $selectedJenisPekerja = array_rand(array_flip($jenisPekerjaIds), $numberOfWorkersToSelect);
                
                // Ensure $selectedJenisPekerja is always an array even if only one is selected
                if (!is_array($selectedJenisPekerja)) {
                    $selectedJenisPekerja = [$selectedJenisPekerja];
                }
                
                // Attach the selected jenis pekerja to the user
                $user->jenisPekerja()->attach($selectedJenisPekerja);
            }
        }
    }
}
