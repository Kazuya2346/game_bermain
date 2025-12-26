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
        Schema::create(table: 'questions', callback: function (Blueprint $table): void {
            $table->id();
            $table->foreignId(column: 'game_id')->nullable()->constrained(table: 'games')->onDelete(action: 'cascade');
            $table->string('category')->nullable(); // TAMBAHKAN INI untuk Survival Quiz
            $table->text(column: 'question_text');
            $table->string(column: 'image_path')->nullable();
            $table->string(column: 'correct_answer');
            $table->json(column: 'options')->nullable();
            $table->string(column: 'location_name')->nullable();
            $table->timestamps();
            
            // Index untuk performa query
            $table->index('game_id');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'questions');
    }
};