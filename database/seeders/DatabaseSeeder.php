<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. User (Admin, Ustadz, Santri) WAJIB dibuat pertama
            UserSeeder::class,

            // 2. Game Survival
            DummySurvivalGameSeeder::class,
            SurvivalQuestionsSeeder::class,

            // 3. Game Sentence Builder
            SentenceBuilderGameSeeder::class,
            SentenceBuilderQuestionsSeeder::class,

            // 4. Game Listening (Audio)
            ListeningAudioSeeder::class,
            UserSeeder::class
        ]);
    }
}
