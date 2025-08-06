<?php

namespace Database\Factories;

use App\Models\TestPaper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestPaper>
 */
class TestPaperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = ['Mathematics', 'Science', 'History', 'Literature', 'Geography', 'Physics', 'Chemistry', 'Biology'];
        $grades = ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th'];

        return [
            'title' => $this->faker->sentence(3) . ' Test',
            'grade_level' => $this->faker->randomElement($grades),
            'subject' => $this->faker->randomElement($subjects),
            'duration_minutes' => $this->faker->randomElement([60, 90, 120, 150, 180]),
            'instructions' => $this->faker->paragraph(3),
            'total_points' => 0, // Will be calculated when questions are added
            'user_id' => User::factory(),
        ];
    }
}