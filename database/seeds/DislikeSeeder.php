<?php

namespace Database\Seeds;

use App\Models\Dislike;
use Illuminate\Database\Seeder;

class DislikeSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            Dislike::factory()->create();
        }
    }
}
