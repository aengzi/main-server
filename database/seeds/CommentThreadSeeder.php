<?php

namespace Database\Seeds;

use App\Models\CommentThread;
use Illuminate\Database\Seeder;

class CommentThreadSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            CommentThread::factory()->create();
        }
    }
}
