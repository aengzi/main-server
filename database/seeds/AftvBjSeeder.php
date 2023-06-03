<?php

namespace Database\Seeds;

use App\Models\AftvBj;
use Illuminate\Database\Seeder;

class AftvBjSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            AftvBj::factory()->create();
        }
    }
}
