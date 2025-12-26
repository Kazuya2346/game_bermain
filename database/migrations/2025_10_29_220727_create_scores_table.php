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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // santri
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->foreignId('question_id')->nullable()->constrained('questions')->onDelete('cascade');
            $table->integer('score'); // nilai yang didapat
            $table->integer('total_questions'); // total soal
            $table->integer('correct_answers'); // jawaban benar
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};