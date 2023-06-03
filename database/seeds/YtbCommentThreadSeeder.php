<?php

namespace Database\Seeds;

use App\Models\YtbCommentThread;
use Illuminate\Database\Seeder;

class YtbCommentThreadSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            YtbCommentThread::factory()->create();
        }
    }
}
