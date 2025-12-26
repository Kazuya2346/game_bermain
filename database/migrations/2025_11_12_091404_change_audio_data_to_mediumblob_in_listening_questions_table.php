<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (config('database.default') === 'pgsql') {
            // PostgreSQL (Neon) - BYTEA bisa menyimpan data unlimited
            DB::statement('ALTER TABLE listening_questions ALTER COLUMN audio_data TYPE BYTEA');
            Log::info('✅ listening_questions.audio_data upgraded to BYTEA (PostgreSQL)');
        } else {
            // MySQL (Lokal) - MEDIUMBLOB = 16MB max
            Schema::table('listening_questions', function (Blueprint $table) {
                $table->mediumBlob('audio_data')->nullable()->change();
            });
            Log::info('✅ listening_questions.audio_data upgraded to MEDIUMBLOB (MySQL)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'pgsql') {
            // PostgreSQL - tetap BYTEA (tidak perlu downgrade)
            Log::info('ℹ️ PostgreSQL BYTEA tidak memerlukan downgrade');
            return;
        }

        // MySQL - Downgrade ke BLOB (65KB max)
        
        // 1. Hitung file yang akan terpotong
        $largeFiles = DB::table('listening_questions')
            ->whereNotNull('audio_data')
            ->whereRaw('LENGTH(audio_data) > 65535') // > 65KB
            ->get(['id', 'level', 'correct_answer']);

        if ($largeFiles->count() > 0) {
            $ids = $largeFiles->pluck('id')->toArray();
            
            Log::warning("⚠️ {$largeFiles->count()} audio files akan dihapus saat rollback!");
            Log::info('IDs yang akan dihapus audio-nya: ' . implode(', ', $ids));

            // 2. Backup ke temporary table (opsional)
            DB::statement('
                CREATE TEMPORARY TABLE IF NOT EXISTS audio_backup AS 
                SELECT id, audio_data, audio_size 
                FROM listening_questions 
                WHERE id IN (' . implode(',', $ids) . ')
            ');
            Log::info('✅ Audio backup dibuat di temporary table');

            // 3. Set audio_data = NULL untuk file besar
            DB::table('listening_questions')
                ->whereIn('id', $ids)
                ->update([
                    'audio_data' => null,
                    'audio_size' => null,
                ]);

            echo "\n⚠️ WARNING: {$largeFiles->count()} audio files telah dihapus karena terlalu besar untuk BLOB.\n";
            echo "IDs: " . implode(', ', $ids) . "\n";
            echo "💡 Gunakan 'audio_backup' temporary table untuk recovery jika diperlukan.\n\n";
        }

        // 4. Downgrade kolom
        Schema::table('listening_questions', function (Blueprint $table) {
            $table->binary('audio_data')->nullable()->change();
        });
        
        Log::info('✅ listening_questions.audio_data downgraded to BLOB (MySQL)');
    }
};