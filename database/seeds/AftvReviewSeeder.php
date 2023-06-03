<?php

namespace Database\Seeds;

use App\Models\AftvReview;
use Illuminate\Database\Seeder;

class AftvReviewSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            AftvReview::factory()->create();
        }
    }
}
