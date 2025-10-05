<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'superadmin'
            ],
            [
                'id' => 2,
                'name' => 'admin'
            ],
            [
                'id' => 3,
                'name' => 'user'
            ]
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['id' => $role['id']],
                [
                    'name' => $role['name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
