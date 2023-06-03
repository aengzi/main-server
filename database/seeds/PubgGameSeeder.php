<?php

namespace Database\Seeds;

use App\Models\PubgGame;
use Illuminate\Database\Seeder;

class PubgGameSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            PubgGame::factory()->create();
        }
    }
}
