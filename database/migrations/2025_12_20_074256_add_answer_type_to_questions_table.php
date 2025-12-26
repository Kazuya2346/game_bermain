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
        Schema::table('questions', function (Blueprint $table) {
            // Menambahkan kolom answer_type setelah game_id
            $table->enum('answer_type', ['multiple_choice', 'essay'])
                  ->default('essay')
                  ->after('game_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Menghapus kolom jika di-rollback
            $table->dropColumn('answer_type');
        });
    }
};