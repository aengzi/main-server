<?php

namespace Database\Seeds;

use App\Models\Vod;
use Illuminate\Database\Seeder;

class VodSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            Vod::factory()->create();
        }
    }
}
