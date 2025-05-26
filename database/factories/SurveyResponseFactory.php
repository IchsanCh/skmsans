<?php

namespace Database\Factories;

use App\Models\Units;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyResponse>
 */
class SurveyResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_id' => Units::inRandomOrder()->first()?->id ?? Units::factory(),
            'service_id' => Service::inRandomOrder()->first()?->id ?? Service::factory(),
            'usia' => $this->faker->numberBetween(17, 65),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'pendidikan' => $this->faker->randomElement(['SD', 'SMP', 'SMA', 'S1', 'S2']),
            'pekerjaan' => $this->faker->jobTitle(),
            'masukan' => $this->faker->optional()->sentence(),
        ];
    }
}
