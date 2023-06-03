<?php

namespace Database\Seeds;

use App\Models\YtbVideo;
use Illuminate\Database\Seeder;

class YtbVideoSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            YtbVideo::factory()->create();
        }
    }
}
