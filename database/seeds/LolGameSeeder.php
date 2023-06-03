<?php

namespace Database\Seeds;

use App\Models\LolGame;
use Illuminate\Database\Seeder;

class LolGameSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            LolGame::factory()->create();
        }
    }
}
