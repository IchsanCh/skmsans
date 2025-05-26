<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\ResponseAnswer;
use App\Models\SurveyResponse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResponseAnswer>
 */
class ResponseAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ResponseAnswer::class;
    public function definition(): array
    {
        $question = Question::inRandomOrder()->first() ?? Question::factory()->create();
        $option = $question->options()->inRandomOrder()->first() ?? $question->options()->create([
            'label' => 'Puas',
            'bobot' => 4,
        ]);
        return [
            'survey_response_id' => SurveyResponse::factory(),
            'question_id' => $question->id,
            'question_option_id' => $option->id,
        ];
    }
}
