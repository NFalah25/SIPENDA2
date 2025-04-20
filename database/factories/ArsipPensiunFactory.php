<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArsipPensiun>
 */
class ArsipPensiunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nomor_pegawai' => $this->faker->unique()->numerify('NP-#####'),
            'unit_kerja' => $this->faker->numberBetween(1, 6),
            'tanggal_surat' => $this->faker->date(),
            'tanggal_diterima' => $this->faker->dateTime(),
            'dokumen1' => $this->faker->word(),
            'dokumen2' => $this->faker->word(),
        ];
    }
}
