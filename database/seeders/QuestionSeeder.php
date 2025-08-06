<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create a test teacher user if none exists
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'name' => 'Test Teacher',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create sample questions for different subjects and grades
        $mathQuestions = [
            [
                'question_text' => 'What is 15 + 28?',
                'question_type' => 'multiple_choice',
                'options' => ['A' => '43', 'B' => '42', 'C' => '44', 'D' => '45'],
                'correct_answer' => 'A',
                'grade_level' => '3rd',
                'textbook' => 'Elementary Mathematics',
                'chapter' => 'Addition and Subtraction',
                'source' => 'textbook',
                'difficulty_level' => 'easy',
                'points' => 2,
            ],
            [
                'question_text' => 'Solve for x: 3x + 7 = 22',
                'question_type' => 'descriptive',
                'options' => null,
                'correct_answer' => 'x = 5',
                'grade_level' => '8th',
                'textbook' => 'Algebra Basics',
                'chapter' => 'Linear Equations',
                'source' => 'sample_exam',
                'difficulty_level' => 'medium',
                'points' => 5,
            ],
            [
                'question_text' => 'Is the statement "All squares are rectangles" true or false?',
                'question_type' => 'true_false',
                'options' => ['True', 'False'],
                'correct_answer' => 'True',
                'grade_level' => '6th',
                'textbook' => 'Geometry Fundamentals',
                'chapter' => 'Quadrilaterals',
                'source' => 'textbook',
                'difficulty_level' => 'medium',
                'points' => 3,
            ]
        ];

        $scienceQuestions = [
            [
                'question_text' => 'What is the chemical formula for water?',
                'question_type' => 'fill_in_blank',
                'options' => null,
                'correct_answer' => 'H2O',
                'grade_level' => '7th',
                'textbook' => 'Basic Chemistry',
                'chapter' => 'Chemical Formulas',
                'source' => 'textbook',
                'difficulty_level' => 'easy',
                'points' => 2,
            ],
            [
                'question_text' => 'Explain the process of photosynthesis in plants.',
                'question_type' => 'descriptive',
                'options' => null,
                'correct_answer' => 'Photosynthesis is the process by which plants convert light energy into chemical energy using chlorophyll, carbon dioxide, and water to produce glucose and oxygen.',
                'grade_level' => '9th',
                'textbook' => 'Biology Essentials',
                'chapter' => 'Plant Biology',
                'source' => 'sample_exam',
                'difficulty_level' => 'hard',
                'points' => 8,
            ],
            [
                'question_text' => 'Which planet is closest to the Sun?',
                'question_type' => 'multiple_choice',
                'options' => ['A' => 'Venus', 'B' => 'Mercury', 'C' => 'Earth', 'D' => 'Mars'],
                'correct_answer' => 'B',
                'grade_level' => '5th',
                'textbook' => 'Earth and Space Science',
                'chapter' => 'Solar System',
                'source' => 'textbook',
                'difficulty_level' => 'easy',
                'points' => 1,
            ]
        ];

        $historyQuestions = [
            [
                'question_text' => 'In which year did World War II end?',
                'question_type' => 'multiple_choice',
                'options' => ['A' => '1944', 'B' => '1945', 'C' => '1946', 'D' => '1947'],
                'correct_answer' => 'B',
                'grade_level' => '10th',
                'textbook' => 'World History',
                'chapter' => 'World War II',
                'source' => 'textbook',
                'difficulty_level' => 'medium',
                'points' => 3,
            ],
            [
                'question_text' => 'Who was the first President of the United States?',
                'question_type' => 'fill_in_blank',
                'options' => null,
                'correct_answer' => 'George Washington',
                'grade_level' => '8th',
                'textbook' => 'American History',
                'chapter' => 'Founding of America',
                'source' => 'textbook',
                'difficulty_level' => 'easy',
                'points' => 2,
            ]
        ];

        // Create all sample questions
        foreach ([$mathQuestions, $scienceQuestions, $historyQuestions] as $subjectQuestions) {
            foreach ($subjectQuestions as $questionData) {
                Question::create(array_merge($questionData, ['user_id' => $teacher->id]));
            }
        }

        // Create additional random questions
        Question::factory()
            ->count(50)
            ->for($teacher)
            ->create();
    }
}