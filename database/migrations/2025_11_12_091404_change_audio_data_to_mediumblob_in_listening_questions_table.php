<?php
// File: database/migrations/XXXX_XX_XX_upgrade_audio_data_to_mediumblob.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Mengubah tipe kolom 'audio_data' dari BLOB (65KB max)
     * menjadi MEDIUMBLOB (16MB max) agar audio file muat.
     * 
     * BLOB Types Comparison:
     * - TINYBLOB:   255 bytes
     * - BLOB:       65 KB (default)
     * - MEDIUMBLOB: 16 MB ✅ (recommended untuk audio)
     * - LONGBLOB:   4 GB (overkill)
     */
    public function up(): void
    {
        // Cek apakah tabel ada dulu
        if (!Schema::hasTable('listening_questions')) {
            throw new \Exception('Table listening_questions does not exist. Run base migration first.');
        }

        // Upgrade ke MEDIUMBLOB
        DB::statement('ALTER TABLE listening_questions MODIFY audio_data MEDIUMBLOB NULL');
        
        // Log untuk tracking
        \Log::info('✅ listening_questions.audio_data upgraded to MEDIUMBLOB (16MB max)');
    }

    /**
     * Reverse the migrations.
     *
     * Mengembalikan ke BLOB standar (65KB).
     * ⚠️ WARNING: Data audio yang > 65KB akan TRUNCATED!
     */
    public function down(): void
    {
        // ⚠️ CRITICAL: Backup & delete data yang > 65KB sebelum downgrade
        
        // 1. Hitung file yang akan terpotong
        $largeFiles = DB::table('listening_questions')
            ->whereNotNull('audio_data')
            ->whereRaw('LENGTH(audio_data) > 65535') // 65KB
            ->get(['id', 'level', 'correct_answer']);

        if ($largeFiles->count() > 0) {
            \Log::warning("⚠️ {$largeFiles->count()} audio files akan dihapus saat rollback!");
            
            // 2. Log IDs untuk recovery jika diperlukan
            $ids = $largeFiles->pluck('id')->toArray();
            \Log::info('IDs yang akan dihapus audio-nya: ' . implode(', ', $ids));
            
            // 3. Set audio_data = NULL untuk file besar
            DB::table('listening_questions')
                ->whereIn('id', $ids)
                ->update([
                    'audio_data' => null,
                    'audio_size' => null,
                ]);
            
            echo "\n⚠️  WARNING: {$largeFiles->count()} audio files telah dihapus karena terlalu besar untuk BLOB.\n";
            echo "IDs: " . implode(', ', $ids) . "\n\n";
        }

        // 4. Sekarang aman untuk downgrade
        DB::statement('ALTER TABLE listening_questions MODIFY audio_data BLOB NULL');
        
        \Log::info('✅ listening_questions.audio_data downgraded to BLOB (65KB max)');
    }
};