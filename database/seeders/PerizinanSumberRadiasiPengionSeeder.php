<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PerizinanSumberRadiasiPengion;

class PerizinanSumberRadiasiPengionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            [
                'nama' => 'Sumber Radiasi X-ray',
                'tipe' => 'Mesin Sinar-X',
                'no_seri' => 'XRAY-001',
                'aktivitas' => '100 mCi',
                'tanggal_aktivitas' => '2023-01-15',
                'kv_ma' => '120kV-50mA',
                'no_ktun' => 'KTUN-X-001',
                'tanggal_berlaku' => '2025-12-31',
                'project_id' => 1
            ],
            [
                'nama' => 'Sumber Gamma Cobalt-60',
                'tipe' => 'Sealed Source',
                'no_seri' => 'CO60-002',
                'aktivitas' => '5 Ci',
                'tanggal_aktivitas' => '2022-07-01',
                'kv_ma' => null,
                'no_ktun' => 'KTUN-G-002',
                'tanggal_berlaku' => '2024-06-30',
                'project_id' => 2
            ],
            
            [
                'nama' => 'Sumber Radiasi X-ray Industrial',
                'tipe' => 'Mesin Sinar-X',
                'no_seri' => 'XRAY-004',
                'aktivitas' => '150 mCi',
                'tanggal_aktivitas' => '2023-03-15',
                'kv_ma' => '150kV-60mA',
                'no_ktun' => 'KTUN-X-004',
                'tanggal_berlaku' => '2025-12-31',
                'project_id' => 1
            ],
            [
                'nama' => 'Sumber Gamma Iridium-192',
                'tipe' => 'Sealed Source',
                'no_seri' => 'IR192-005',
                'aktivitas' => '3 Ci',
                'tanggal_aktivitas' => '2023-06-01',
                'kv_ma' => null,
                'no_ktun' => 'KTUN-G-005',
                'tanggal_berlaku' => '2024-12-31',
                'project_id' => 2
            ]
        ];

        foreach ($sources as $source) {
            PerizinanSumberRadiasiPengion::create($source);
        }
    }
}
