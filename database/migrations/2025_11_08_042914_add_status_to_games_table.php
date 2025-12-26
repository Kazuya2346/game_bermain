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
            // Menambahkan kolom status
            // 'draft' = Dibuat, tapi belum siap
            // 'published' = Siap dimainkan oleh santri
            $table->enum('status', ['draft', 'published'])
                  ->default('draft')
                  ->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};