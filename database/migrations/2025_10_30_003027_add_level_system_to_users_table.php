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
            // 1. Cek level dulu
            if (!Schema::hasColumn('users', 'level')) {
                $table->integer('level')->default(1)->after('role');
            }
            
            // 2. Exp
            if (!Schema::hasColumn('users', 'experience_points')) {
                $table->integer('experience_points')->default(0)->after('level');
            }
            
            // 3. TOTAL SCORE (Ini yang tadi hilang!)
            if (!Schema::hasColumn('users', 'total_score')) {
                $table->integer('total_score')->default(0)->after('experience_points');
            }

            // 4. Games Completed (Kita buat disini, supaya file 14 Nov tidak perlu ada)
            if (!Schema::hasColumn('users', 'total_games_completed')) {
                $table->integer('total_games_completed')->default(0)->after('total_score');
            }

            // 5. Badge
            if (!Schema::hasColumn('users', 'current_badge')) {
                $table->string('current_badge')->nullable()->after('total_games_completed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $columns = [
                'level', 
                'experience_points', 
                'total_score', 
                'total_games_completed', 
                'current_badge'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};