<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Password default untuk memudahkan testing
        $defaultPassword = Hash::make('password'); 

        // ==========================================
        // 1. ADMIN (Super User)
        // ==========================================
        User::create([
            'name' => 'Admin TPQ',
            'email' => 'admin@tpq.com',
            'password' => $defaultPassword,
            'role' => 'admin',
            'class_id' => null, // Admin tidak butuh kelas
            'no_telepon' => '081200000000',
            
            // Data Statistik Awal (Wajib 0/1 biar tidak error null)
            'level' => 1,
            'experience_points' => 0,
            'total_score' => 0,             // Ini kolom yang tadi kita selamatkan!
            'total_games_completed' => 0,   // Ini juga!
        ]);

        // ==========================================
        // 2. GURU (Ustadz & Ustadzah)
        // ==========================================
        User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ustadz@tpq.com',
            'password' => $defaultPassword,
            'role' => 'ustadz',
            'class_id' => null,
            'no_telepon' => '081211111111',
            'level' => 1,
            'experience_points' => 0,
            'total_score' => 0,
            'total_games_completed' => 0,
        ]);

        User::create([
            'name' => 'Ustadzah Fatimah',
            'email' => 'ustadzah@tpq.com',
            'password' => $defaultPassword,
            'role' => 'ustadzah',
            'class_id' => null,
            'no_telepon' => '081222222222',
            'level' => 1,
            'experience_points' => 0,
            'total_score' => 0,
            'total_games_completed' => 0,
        ]);

        // ==========================================
        // 3. SANTRI (Siswa)
        // ==========================================
        
        // Santri Putra - Kelas A
        User::create([
            'name' => 'Muhammad Ali',
            'email' => 'ali@tpq.com',
            'password' => $defaultPassword,
            'role' => 'santri_putra',
            'class_id' => 'Kelas A',
            'no_telepon' => '081233333333',
            'level' => 1,
            'experience_points' => 0,
            'total_score' => 0,
            'total_games_completed' => 0,
        ]);

        // Santri Putri - Kelas A
        User::create([
            'name' => 'Aisyah Zahra',
            'email' => 'aisyah@tpq.com',
            'password' => $defaultPassword,
            'role' => 'santri_putri',
            'class_id' => 'Kelas A',
            'no_telepon' => '081244444444',
            'level' => 1,
            'experience_points' => 0,
            'total_score' => 0,
            'total_games_completed' => 0,
        ]);

        // Santri Tambahan 1 (Qoizo) - Kelas B
        User::create([
            'name' => 'qoizo',
            'email' => 'qoizo@com',
            'password' => $defaultPassword,
            'role' => 'santri_putra',
            'class_id' => 'Kelas B',
            'no_telepon' => null, // Boleh kosong karena di controller nullable
            'level' => 1,
            'experience_points' => 0,
            'total_score' => 0,
            'total_games_completed' => 0,
        ]);

        // Santri Tambahan 2 (Kuza) - Kelas B
        User::create([
            'name' => 'kuza',
            'email' => 'kuza@com',
            'password' => $defaultPassword,
            'role' => 'santri_putra',
            'class_id' => 'Kelas B',
            'no_telepon' => null,
            'level' => 1,
            'experience_points' => 0,
            'total_score' => 0,
            'total_games_completed' => 0,
        ]);
    }
}