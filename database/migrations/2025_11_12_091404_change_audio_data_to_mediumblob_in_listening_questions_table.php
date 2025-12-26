<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('listening_questions', function (Blueprint $table) {
            // Mengubah tipe data menjadi string untuk simpan nama file saja
            $table->string('audio_data')->nullable()->change();
        });
    }
    public function down(): void {
        Schema::table('listening_questions', function (Blueprint $table) {
            $table->string('audio_data')->nullable()->change();
        });
    }
};