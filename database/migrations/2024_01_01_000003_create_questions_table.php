<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text')->comment('The main question content');
            $table->enum('question_type', [
                'multiple_choice',
                'true_false',
                'descriptive',
                'matching',
                'fill_in_blank'
            ])->comment('Type of question');
            $table->json('options')->nullable()->comment('Options for multiple choice, matching pairs, etc.');
            $table->string('correct_answer')->nullable()->comment('Correct answer for the question');
            $table->string('grade_level')->comment('Educational grade level');
            $table->string('textbook')->comment('Source textbook name');
            $table->string('chapter')->comment('Textbook chapter');
            $table->enum('source', [
                'textbook',
                'sample_exam',
                'practice_sheet',
                'custom'
            ])->comment('Source of the question');
            $table->enum('difficulty_level', [
                'easy',
                'medium',
                'hard'
            ])->comment('Difficulty rating');
            $table->integer('points')->default(1)->comment('Points/score value for the question');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Indexes for efficient filtering
            $table->index('question_type');
            $table->index('grade_level');
            $table->index('textbook');
            $table->index('chapter');
            $table->index('source');
            $table->index('difficulty_level');
            $table->index('user_id');
            $table->index(['grade_level', 'textbook', 'chapter']);
            $table->index(['difficulty_level', 'question_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};