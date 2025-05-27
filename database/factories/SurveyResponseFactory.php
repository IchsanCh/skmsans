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
            'usia' => $this->faker->numberBetween(13, 99),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'pendidikan' => $this->faker->randomElement(['SD Kebawah', 'SMP', 'SMA/K', 'D1 - D4', 'S1', 'S2 Keatas']),
            'pekerjaan' => $this->faker->randomElement(['TNI', 'Polri', 'PNS', 'Pegawai Swasta', 'Wirausaha', 'lainnya']),
            'masukan' => $this->faker->optional()->sentence(),
        ];
    }
}
