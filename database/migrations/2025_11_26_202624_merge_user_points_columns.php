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
        // 1. AMANKAN DATA: Pindahkan nilai dari kolom 'game listening' ke kolom utama
        // Kita gunakan COALESCE agar jika nilainya null dianggap 0
        DB::statement('UPDATE users SET experience_points = COALESCE(experience_points, 0) + COALESCE(total_exp, 0)');
        DB::statement('UPDATE users SET total_score = COALESCE(total_score, 0) + COALESCE(total_points, 0)');

        // 2. BERSIH-BERSIH: Hapus kolom 'game listening' yang sekarang sudah kosong/tidak perlu
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_exp', 'total_points']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Jika di-rollback, buat lagi kolomnya (meskipun datanya sudah tercampur di kolom utama)
        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_points')->default(0);
            $table->integer('total_exp')->default(0);
        });
    }
};