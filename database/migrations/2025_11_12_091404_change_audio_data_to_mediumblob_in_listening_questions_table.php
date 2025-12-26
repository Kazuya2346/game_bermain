<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Deteksi apakah menggunakan PostgreSQL (Koyeb/Neon)
        if (config('database.default') === 'pgsql') {
            // Syntax PostgreSQL: ALTER COLUMN dan tipe BYTEA
            DB::statement('ALTER TABLE listening_questions ALTER COLUMN audio_data TYPE BYTEA USING audio_data::bytea');
        } else {
            // Syntax MySQL (Lokal): MODIFY dan tipe MEDIUMBLOB
            Schema::table('listening_questions', function (Blueprint $table) {
                $table->mediumBlob('audio_data')->nullable()->change();
            });
        }
        
        \Log::info('✅ listening_questions.audio_data upgraded successfully');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'pgsql') {
            // Kembali ke BYTEA standar di PostgreSQL
            DB::statement('ALTER TABLE listening_questions ALTER COLUMN audio_data TYPE BYTEA');
        } else {
            // Kembali ke BLOB standar di MySQL
            Schema::table('listening_questions', function (Blueprint $table) {
                $table->binary('audio_data')->nullable()->change();
            });
        }
    }
};