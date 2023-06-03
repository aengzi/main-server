<?php

namespace Database\Seeds;

use App\Models\Clip;
use Illuminate\Database\Seeder;

class ClipSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            Clip::factory()->create();
        }
    }
}
