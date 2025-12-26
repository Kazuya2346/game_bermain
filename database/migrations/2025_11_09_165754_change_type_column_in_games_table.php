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
        Schema::table('games', function (Blueprint $table) {
            // ⭐ Ubah kolom 'type' menjadi string dengan panjang standar (varchar 255)
            $table->string('type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Opsi: Kembalikan ke panjang sebelumnya jika perlu, misalnya varchar(50)
            // $table->string('type', 50)->nullable()->change();
        });
    }
};