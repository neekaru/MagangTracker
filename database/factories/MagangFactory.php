<?php

namespace Database\Factories;

use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\UnitBisnis;
use App\Models\Dosen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Magang>
 */
class MagangFactory extends Factory
{
    protected $model = Magang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $endDate = $this->faker->dateTimeBetween($startDate, '+6 months');

        return [
            'id_mahasiswa' => Mahasiswa::factory(),
            'unit_id' => UnitBisnis::factory(),
            'periode_id' => \App\Models\PeriodeMagang::factory(),
            'id_dosen' => Dosen::factory(),
            'pembimbing_lapangan' => $this->faker->name(),
            'tanggal_mulai' => $startDate,
            'tanggal_selesai' => $endDate,
            'status_magang' => $this->faker->randomElement(['Pending', 'Aktif', 'Nonaktif', 'selesai', 'dibatalkan']),
            'target_book_mingguan' => $this->faker->numberBetween(1, 5),
            'tugas_description' => $this->faker->optional()->paragraph(),
        ];
    }
}
