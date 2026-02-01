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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->string('label'); // A, B, C, D, E
            $table->text('option_text');
            $table->integer('points')->default(0); // For TKP: 1-5
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->index('question_id');
        });

        // Add foreign key for correct_option_id after options table exists
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('correct_option_id')
                ->references('id')
                ->on('options')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['correct_option_id']);
        });
        Schema::dropIfExists('options');
    }
};
