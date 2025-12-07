<?php

namespace Database\Factories;

use App\Models\Logbook;
use App\Models\Magang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Logbook>
 */
class LogbookFactory extends Factory
{
    protected $model = Logbook::class;

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
            'magang_id' => Magang::factory(),
            'tanggal_logbook' => $startDate,
            'jam_mulai' => $this->faker->time('H:i'),
            'jam_selesai' => $this->faker->time('H:i', $endDate->getTimestamp()),
            'deskripsi_kegiatan' => $this->faker->sentence(),
            'hasil_kegiatan' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'approved_by' => null,
        ];
    }
}
