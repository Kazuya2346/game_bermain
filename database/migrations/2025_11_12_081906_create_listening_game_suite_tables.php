<?php
// File: database/migrations/XXXX_XX_XX_create_listening_game_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * 1️⃣ Membuat tabel `listening_questions`
         */
        Schema::create('listening_questions', function (Blueprint $table) {
            $table->id();
            $table->enum('level', ['low', 'medium', 'hard']);
            $table->string('speaker')->nullable();
            
            // Audio storage (akan diubah ke MEDIUMBLOB di migration terpisah)
            $table->binary('audio_data')->nullable();
            $table->string('audio_mime_type')->nullable();
            $table->integer('audio_size')->nullable();
            
            // Question data
            $table->integer('word_count')->nullable();
            $table->string('question_text');
            $table->string('correct_answer');
            $table->string('answer_type')->default('multiple_choice');
            
            // Multiple choice options
            $table->string('option_a')->nullable();
            $table->string('option_b')->nullable();
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            
            // Rewards
            $table->integer('exp_reward')->default(10);
            $table->integer('play_count_limit')->default(2);
            
            $table->timestamps();

            // Indexes untuk performa
            $table->index('level');
            $table->index('speaker');
            
            // Set charset & collation (cara Laravel)
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        /**
         * 2️⃣ Membuat tabel `leaderboard`
         */
        Schema::create('leaderboard', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->onDelete('cascade');
            
            $table->integer('rank')->nullable();
            $table->integer('total_points')->default(0);
            $table->integer('total_exp')->default(0);
            $table->timestamp('last_updated')->nullable();
            
            $table->timestamps();

            // Indexes untuk leaderboard queries
            $table->index(['total_points', 'total_exp']);
            $table->index('rank');
        });

        /**
         * 3️⃣ Membuat tabel `game_sessions` (untuk tracking gameplay)
         */
        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            
            // Polymorphic relationship (optional - bisa untuk berbagai tipe soal)
            $table->morphs('questionable');
            
            // Game metadata
            $table->enum('level_type', ['low', 'medium', 'hard', 'other'])->default('other');
            $table->string('question_text', 500);
            $table->text('user_answer');
            
            // Answer data
            $table->boolean('is_correct')->default(false);
            $table->integer('attempts')->default(1);
            $table->integer('time_taken')->default(0); // in seconds
            
            // Rewards
            $table->integer('points_earned')->default(0);
            $table->integer('exp_earned')->default(0);
            
            // Gameplay features
            $table->boolean('used_hint')->default(false);
            $table->integer('streak_at_time')->default(0);
            
            $table->timestamp('created_at')->useCurrent();

            // Indexes untuk analytics
            $table->index(['user_id', 'created_at']);
            $table->index('level_type');
            $table->index('is_correct');
            
            // Set charset & collation (cara Laravel)
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        /**
         * 4️⃣ Update tabel `users` - Tambah kolom statistik
         */
        Schema::table('users', function (Blueprint $table) {
            // Points & Experience
            if (!Schema::hasColumn('users', 'total_points')) {
                $table->integer('total_points')->default(0)->after('email');
            }
            if (!Schema::hasColumn('users', 'total_exp')) {
                $table->integer('total_exp')->default(0)->after('total_points');
            }
            
            // Streaks (FIXED: gunakan longest_streak konsisten dengan naming)
            if (!Schema::hasColumn('users', 'current_streak')) {
                $table->integer('current_streak')->default(0)->after('total_exp');
            }
            if (!Schema::hasColumn('users', 'longest_streak')) {
                $table->integer('longest_streak')->default(0)->after('current_streak');
            }
            
            // Game features usage
            if (!Schema::hasColumn('users', 'hints_used')) {
                $table->integer('hints_used')->default(0)->after('longest_streak');
            }
            if (!Schema::hasColumn('users', 'skips_used')) {
                $table->integer('skips_used')->default(0)->after('hints_used');
            }
            
            // Question statistics
            if (!Schema::hasColumn('users', 'total_questions')) {
                $table->integer('total_questions')->default(0)->after('skips_used');
            }
            if (!Schema::hasColumn('users', 'correct_answers')) {
                $table->integer('correct_answers')->default(0)->after('total_questions');
            }
            
            // Last activity
            if (!Schema::hasColumn('users', 'last_played')) {
                $table->timestamp('last_played')->nullable()->after('correct_answers');
            }
        });

        // Add indexes untuk leaderboard sorting (only if not exists)
        try {
            DB::statement('CREATE INDEX IF NOT EXISTS users_total_exp_index ON users(total_exp)');
        } catch (\Exception $e) {
            // Index already exists
        }
        
        try {
            DB::statement('CREATE INDEX IF NOT EXISTS users_total_points_index ON users(total_points)');
        } catch (\Exception $e) {
            // Index already exists
        }
    }

    public function down(): void
    {
        /**
         * ✅ Rollback dalam urutan terbalik (karena foreign keys)
         */
        
        // 1. Drop indexes dari users table
        $userIndexes = [
            'users_total_exp_index',
            'users_total_points_index',
        ];

        foreach ($userIndexes as $indexName) {
            try {
                // Check if index exists first
                $exists = DB::select("SHOW INDEX FROM users WHERE Key_name = ?", [$indexName]);
                if (!empty($exists)) {
                    DB::statement("ALTER TABLE users DROP INDEX `{$indexName}`");
                }
            } catch (\Exception $e) {
                // Ignore if index doesn't exist
            }
        }

        // 2. Drop kolom dari users (hanya jika ada)
        $columnsToRemove = [
            'total_points', 
            'total_exp', 
            'current_streak', 
            'longest_streak',
            'hints_used', 
            'skips_used', 
            'total_questions', 
            'correct_answers', 
            'last_played'
        ];

        foreach ($columnsToRemove as $column) {
            if (Schema::hasColumn('users', $column)) {
                Schema::table('users', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }

        // 3. Drop tables (reverse order karena foreign keys)
        Schema::dropIfExists('game_sessions');
        Schema::dropIfExists('leaderboard');
        Schema::dropIfExists('listening_questions');
    }
};