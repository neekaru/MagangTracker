<?php

namespace Database\Factories;

use App\Models\UnitBisnis;
use App\Models\PeriodeMagang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitBisnis>
 */
class UnitBisnisFactory extends Factory
{
    protected $model = UnitBisnis::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_unit_bisnis' => $this->faker->randomElement(['IT Department', 'HR Department', 'Finance Department', 'Marketing Department', 'Operations Department']),
        ];
    }
}
