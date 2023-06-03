<?php

namespace Database\Seeds;

use App\Models\PubgTimeline;
use Illuminate\Database\Seeder;

class PubgTimelineSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            PubgTimeline::factory()->create();
        }
    }
}
