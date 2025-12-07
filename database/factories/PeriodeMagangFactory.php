<?php

namespace Database\Factories;

use App\Models\PeriodeMagang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PeriodeMagang>
 */
class PeriodeMagangFactory extends Factory
{
    protected $model = PeriodeMagang::class;

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
            'nama_periode' => 'Periode ' . $this->faker->year() . ' - ' . $this->faker->randomElement(['Semester 1', 'Semester 2']),
            'tanggal_mulai' => $startDate,
            'tanggal_selesai' => $endDate,
            'status_magang' => $this->faker->randomElement(['Aktif', 'Nonaktif']),
        ];
    }
}
