<?php

namespace Database\Seeds;

use App\Models\AftvFile;
use Illuminate\Database\Seeder;

class AftvFileSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            AftvFile::factory()->create();
        }
    }
}
