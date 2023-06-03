<?php

namespace Database\Seeds;

use App\Models\CommentReply;
use Illuminate\Database\Seeder;

class CommentReplySeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            CommentReply::factory()->create();
        }
    }
}
