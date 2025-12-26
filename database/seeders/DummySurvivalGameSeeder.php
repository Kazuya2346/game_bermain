<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class DummySurvivalGameSeeder extends Seeder
{
    public function run(): void
    {
        Game::updateOrCreate(
            ['type' => 'survival'], // Cari berdasarkan tipe
            [
                'title' => 'Survival Quiz',
                'description' => 'Mode permainan bertahan hidup dengan waktu dan nyawa terbatas.',
                'status' => 'published',
            ]
        );

        $this->command->info('✅ Dummy game "Survival Quiz" telah dibuat/diperbarui.');
    }
}
