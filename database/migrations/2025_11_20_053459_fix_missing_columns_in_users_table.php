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
        Schema::table('users', function (Blueprint $table) {
            // 1. Cek apakah total_score hilang? Jika ya, buatkan.
            if (!Schema::hasColumn('users', 'total_score')) {
                // Taruh setelah experience_points jika ada, atau setelah email defaultnya
                $after = Schema::hasColumn('users', 'experience_points') ? 'experience_points' : 'email';
                $table->integer('total_score')->default(0)->after($after);
            }

            // 2. Cek total_games_completed
            if (!Schema::hasColumn('users', 'total_games_completed')) {
                $after = Schema::hasColumn('users', 'total_score') ? 'total_score' : 'email';
                $table->integer('total_games_completed')->default(0)->after($after);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu melakukan apa-apa saat rollback agar data aman
    }
};