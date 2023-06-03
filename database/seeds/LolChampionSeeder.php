<?php

namespace Database\Seeds;

use App\Models\LolChampion;
use Illuminate\Database\Seeder;

class LolChampionSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            LolChampion::factory()->create();
        }
    }
}
