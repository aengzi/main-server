<?php

namespace Database\Seeds;

use App\Models\LolMeta;
use Illuminate\Database\Seeder;

class LolMetaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            LolMeta::factory()->create();
        }
    }
}
