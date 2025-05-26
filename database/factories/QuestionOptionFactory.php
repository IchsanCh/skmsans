<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionOption>
 */
class QuestionOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'label' => $this->faker->randomElement(['Tidak Baik', 'Kurang Baik', 'Baik', 'Sangat Baik']),
            'bobot' => $this->faker->numberBetween(1, 4),
        ];
    }
}
