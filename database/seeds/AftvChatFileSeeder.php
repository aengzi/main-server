<?php

namespace Database\Seeds;

use App\Models\AftvChatFile;
use Illuminate\Database\Seeder;

class AftvChatFileSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            AftvChatFile::factory()->create();
        }
    }
}
