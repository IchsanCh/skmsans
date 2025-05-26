<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Units;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Service;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\SurveyResponse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Ichsan',
            'email' => 'test@gmail.com',
            'password' => bcrypt('123'),
        ]);
        // Units::factory(10)->create()->each(function ($unit) {
        //     Service::factory(5)->create([
        //         'unit_id' => $unit->id,
        //     ]);
        // });
        Question::factory(9)->create()->each(function ($question) {
            $options = [
                ['label' => 'Sangat Baik', 'bobot' => 4],
                ['label' => 'Baik', 'bobot' => 3],
                ['label' => 'Kurang Baik', 'bobot' => 2],
                ['label' => 'Tidak Baik', 'bobot' => 1],
            ];

            foreach ($options as $option) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'label' => $option['label'],
                    'bobot' => $option['bobot'],
                ]);
            }
        });
        // SurveyResponse::factory(100)->create()->each(function ($response) {
        //     // Jawab 10 pertanyaan
        //     $questions = Question::all();
        //     foreach ($questions as $question) {
        //         $option = $question->questionOptions()->inRandomOrder()->first();
        //         $response->responseAnswers()->create([
        //             'question_id' => $question->id,
        //             'question_option_id' => $option->id,
        //         ]);
        //     }
        // });
    }
}
