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
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')
                ->constrained()
                ->noActionOnDelete();
            $table->foreignId('selected_option_id')->nullable()->constrained('options')->onDelete('set null');
            $table->boolean('is_correct')->default(false);
            $table->integer('points_earned')->default(0);
            $table->integer('time_spent_seconds')->default(0);
            $table->boolean('is_bookmarked')->default(false);
            $table->timestamps();

            $table->unique(['test_attempt_id', 'question_id']);
            $table->index('test_attempt_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
