<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Lesson;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some published lessons to attach quizzes to
        $lessons = Lesson::where('is_published', true)->take(5)->get();

        if ($lessons->isEmpty()) {
            $this->command->info('No published lessons found. Skipping quiz seeding.');
            return;
        }

        $quizData = [
            [
                'title' => 'Introduction Quiz',
//                'description' => 'Test your knowledge of the course fundamentals',
                'settings' => [
                    'time_limit' => 30,
                    'passing_score' => 70,
                    'max_attempts' => 3,
                    'is_active' => true,
                    'shuffle_questions' => false,
                    'show_results' => true,
                    'allow_review' => true,
                ]
            ],
            [
                'title' => 'Advanced Concepts Assessment',
//                'description' => 'Comprehensive quiz covering advanced topics',
                'settings' => [
                    'time_limit' => 45,
                    'passing_score' => 80,
                    'max_attempts' => 2,
                    'is_active' => true,
                    'shuffle_questions' => true,
                    'show_results' => true,
                    'allow_review' => false,
                ]
            ],
            [
                'title' => 'Quick Knowledge Check',
//                'description' => 'Short quiz to verify understanding',
                'settings' => [
                    'time_limit' => 15,
                    'passing_score' => 60,
                    'max_attempts' => 5,
                    'is_active' => true,
                    'shuffle_questions' => true,
                    'show_results' => true,
                    'allow_review' => true,
                ]
            ],
            [
                'title' => 'Practice Quiz',
//                'description' => 'Practice quiz with no time limit',
                'settings' => [
                    'time_limit' => null,
                    'passing_score' => 50,
                    'max_attempts' => 10,
                    'is_active' => true,
                    'shuffle_questions' => false,
                    'show_results' => true,
                    'allow_review' => true,
                ]
            ],
            [
                'title' => 'Final Assessment',
//                'description' => 'Comprehensive final quiz for the course',
                'settings' => [
                    'time_limit' => 60,
                    'passing_score' => 85,
                    'max_attempts' => 1,
                    'is_active' => false, // Inactive for now
                    'shuffle_questions' => true,
                    'show_results' => false,
                    'allow_review' => false,
                ]
            ]
        ];

        foreach ($quizData as $index => $data) {
            if (isset($lessons[$index])) {
                Quiz::create([
                    'lesson_id' => $lessons[$index]->id,
                    'title' => $data['title'],
//                    'description' => $data['description'],
                    'settings' => $data['settings'],
                ]);
            }
        }

        $this->command->info('Sample quizzes created successfully!');
    }
}
