<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $questionTypes = ['multiple_choice', 'true_false', 'descriptive', 'matching', 'fill_in_blank'];
        $type = $this->faker->randomElement($questionTypes);
        
        $options = null;
        $correctAnswer = null;
        
        // Generate appropriate options and answers based on type
        switch ($type) {
            case 'multiple_choice':
                $options = [
                    'A' => $this->faker->sentence(4),
                    'B' => $this->faker->sentence(4),
                    'C' => $this->faker->sentence(4),
                    'D' => $this->faker->sentence(4),
                ];
                $correctAnswer = $this->faker->randomElement(['A', 'B', 'C', 'D']);
                break;
                
            case 'true_false':
                $options = ['True', 'False'];
                $correctAnswer = $this->faker->randomElement(['True', 'False']);
                break;
                
            case 'matching':
                $options = [
                    'left' => [
                        $this->faker->word(),
                        $this->faker->word(),
                        $this->faker->word(),
                    ],
                    'right' => [
                        $this->faker->word(),
                        $this->faker->word(),
                        $this->faker->word(),
                    ]
                ];
                $correctAnswer = '1-A, 2-B, 3-C';
                break;
                
            case 'fill_in_blank':
                $correctAnswer = $this->faker->word();
                break;
                
            case 'descriptive':
                $correctAnswer = $this->faker->sentence(10);
                break;
        }

        return [
            'question_text' => $this->faker->sentence(8) . '?',
            'question_type' => $type,
            'options' => $options,
            'correct_answer' => $correctAnswer,
            'grade_level' => $this->faker->randomElement(['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th']),
            'textbook' => $this->faker->randomElement(['Mathematics', 'Science', 'History', 'Literature', 'Geography', 'Physics', 'Chemistry', 'Biology']),
            'chapter' => $this->faker->randomElement(['Chapter 1', 'Chapter 2', 'Chapter 3', 'Chapter 4', 'Chapter 5']),
            'source' => $this->faker->randomElement(['textbook', 'sample_exam', 'practice_sheet', 'custom']),
            'difficulty_level' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'points' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Create a multiple choice question.
     */
    public function multipleChoice(): static
    {
        return $this->state(fn (array $attributes) => [
            'question_type' => 'multiple_choice',
            'options' => [
                'A' => fake()->sentence(4),
                'B' => fake()->sentence(4),
                'C' => fake()->sentence(4),
                'D' => fake()->sentence(4),
            ],
            'correct_answer' => fake()->randomElement(['A', 'B', 'C', 'D']),
        ]);
    }

    /**
     * Create a true/false question.
     */
    public function trueFalse(): static
    {
        return $this->state(fn (array $attributes) => [
            'question_type' => 'true_false',
            'options' => ['True', 'False'],
            'correct_answer' => fake()->randomElement(['True', 'False']),
        ]);
    }

    /**
     * Create a descriptive question.
     */
    public function descriptive(): static
    {
        return $this->state(fn (array $attributes) => [
            'question_type' => 'descriptive',
            'options' => null,
            'correct_answer' => fake()->paragraph(),
        ]);
    }
}