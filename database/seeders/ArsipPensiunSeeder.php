<?php

namespace Database\Seeders;

use App\Models\ArsipPensiun;
use Database\Factories\ArsipPensiunFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArsipPensiunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create factory 10 data
        ArsipPensiun::factory(20)->create();
    }
}
