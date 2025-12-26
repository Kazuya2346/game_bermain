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
        // Cek apakah tabel 'games' ada
        if (Schema::hasTable('games')) {
            
            // Cek apakah kolom 'created_by' ada
            if (Schema::hasColumn('games', 'created_by')) {
                
                // Set nilai default NULL untuk data yang sudah ada (jika ada)
                DB::statement('UPDATE games SET created_by = NULL WHERE created_by = 0 OR created_by IS NULL');
                
                // Ubah kolom jadi nullable
                Schema::table('games', function (Blueprint $table) {
                    $table->unsignedBigInteger('created_by')->nullable()->change();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('games') && Schema::hasColumn('games', 'created_by')) {
            Schema::table('games', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by')->nullable(false)->change();
            });
        }
    }
};