<?php

namespace Database\Seeds;

use App\Models\YtbChannel;
use Illuminate\Database\Seeder;

class YtbChannelSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            YtbChannel::factory()->create();
        }
    }
}
