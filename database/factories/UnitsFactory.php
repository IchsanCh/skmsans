<?php

namespace Database\Factories;

use App\Models\Units;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Units>
 */
class UnitsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Units::class;
    public function definition(): array
    {
        return [
            'nama' => $this->faker->company . ' units',
        ];
    }
}
