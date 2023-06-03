<?php

namespace Database\Seeds;

use App\Models\YtbCommentReply;
use Illuminate\Database\Seeder;

class YtbCommentReplySeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            YtbCommentReply::factory()->create();
        }
    }
}
