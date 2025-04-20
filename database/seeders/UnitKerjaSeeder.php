<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitKerja = [
            'UP3 Surabaya Selatan',
            'ULP Ngagel',
            'ULP Rungkut',
            'ULP Dukuh Kupang',
            'ULP Darmo Permai',
            'ULP Gedangan',
        ];

        foreach ($unitKerja as $uk) {
            UnitKerja::create([
                'unit_kerja' => $uk,
            ]);
        }
    }
}
