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
        // Cek apakah table 'answers' ada, kalau ada rename ke 'answer_logs'
        if (Schema::hasTable('answers') && !Schema::hasTable('answer_logs')) {
            Schema::rename('answers', 'answer_logs');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('answer_logs') && !Schema::hasTable('answers')) {
            Schema::rename('answer_logs', 'answers');
        }
    }
};