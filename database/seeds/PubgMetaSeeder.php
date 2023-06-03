<?php

namespace Database\Seeds;

use App\Models\PubgMeta;
use Illuminate\Database\Seeder;

class PubgMetaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            PubgMeta::factory()->create();
        }
    }
}
