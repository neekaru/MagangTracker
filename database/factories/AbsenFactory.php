<?php

namespace Database\Factories;

use App\Models\Absen;
use App\Models\Magang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absen>
 */
class AbsenFactory extends Factory
{
    protected $model = Absen::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'magang_id' => Magang::factory(),
            'tanggal' => $this->faker->dateTime(),
            'jam' => $this->faker->time('H:i:s'),
            'status_kehadiran' => $this->faker->randomElement(['Hadir', 'Izin', 'Sakit']),
            'id_unit_bisnis' => \App\Models\UnitBisnis::factory(),
            'keterangan' => $this->faker->optional()->sentence(),
        ];
    }
}
