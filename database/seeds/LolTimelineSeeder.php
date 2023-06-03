<?php

namespace Database\Seeds;

use App\Models\LolTimeline;
use Illuminate\Database\Seeder;

class LolTimelineSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            LolTimeline::factory()->create();
        }
    }
}
