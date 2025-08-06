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
        Schema::create('test_paper_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_paper_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->integer('order')->comment('Order of question in the test');
            $table->timestamps();
            
            // Ensure unique question per test paper
            $table->unique(['test_paper_id', 'question_id']);
            
            // Indexes
            $table->index('test_paper_id');
            $table->index('question_id');
            $table->index(['test_paper_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_paper_questions');
    }
};