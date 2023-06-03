<?php

namespace Database\Seeds;

use App\Models\AftvBcast;
use Illuminate\Database\Seeder;

class AftvBcastSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            AftvBcast::factory()->create();
        }
    }
}
