<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
  
{
    // Gunakan DB::statement karena tipe data BLOB di MySQL berbeda dengan BYTEA di PostgreSQL
    if (config('database.default') === 'pgsql') {
        DB::statement('ALTER TABLE listening_questions ALTER COLUMN audio_data TYPE BYTEA');
    } else {
        Schema::table('listening_questions', function (Blueprint $table) {
            $table->mediumBlob('audio_data')->nullable()->change();
        });
    }
}

    public function down(): void
    {
        
        
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