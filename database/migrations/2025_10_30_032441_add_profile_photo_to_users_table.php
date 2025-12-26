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
        Schema::table('users', function (Blueprint $table) {
            // HANYA buat profile_photo. 
            // Jangan ada total_score di sini!
            if (!Schema::hasColumn('users', 'profile_photo')) {
                $after = Schema::hasColumn('users', 'current_badge') ? 'current_badge' : 'email';
                $table->string('profile_photo')->nullable()->after($after);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus profile_photo saja
            if (Schema::hasColumn('users', 'profile_photo')) {
                $table->dropColumn('profile_photo');
            }
        });
    }
};
