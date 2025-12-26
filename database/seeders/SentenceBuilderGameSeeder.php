<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class SentenceBuilderGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Game::updateOrCreate(
            // Cari game berdasarkan 'type' yang unik
            ['type' => 'sentence_builder'],
            [
                'title' => 'Arabic Sentence Builder',
                'description' => 'Susun kata-kata acak menjadi kalimat Bahasa Arab yang benar.',
                'status' => 'published',
            ]
        );

        $this->command->info('✅ Game "Arabic Sentence Builder" telah dibuat/diperbarui.');
    }
}