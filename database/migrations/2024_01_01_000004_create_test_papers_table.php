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
        Schema::create('test_papers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Name/title of the test paper');
            $table->string('grade_level')->comment('Target grade level for the test');
            $table->string('subject')->comment('Subject area of the test');
            $table->integer('duration_minutes')->nullable()->comment('Test duration in minutes');
            $table->text('instructions')->nullable()->comment('Test instructions for students');
            $table->integer('total_points')->default(0)->comment('Total points for the test');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Indexes
            $table->index('grade_level');
            $table->index('subject');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_papers');
    }
};