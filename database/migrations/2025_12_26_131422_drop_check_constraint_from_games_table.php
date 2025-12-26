<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kita harus menghapus constraint secara manual di PostgreSQL
        if (config('database.default') === 'pgsql') {
            DB::statement('ALTER TABLE games DROP CONSTRAINT IF EXISTS games_type_check');
        }
    }
    
    public function down(): void
    {
        // Tidak perlu dikembalikan karena kolom sudah menjadi string
    }
};
