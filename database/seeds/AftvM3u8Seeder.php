<?php

namespace Database\Seeds;

use App\Models\AftvM3u8;
use Illuminate\Database\Seeder;

class AftvM3u8Seeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            AftvM3u8::factory()->create();
        }
    }
}
