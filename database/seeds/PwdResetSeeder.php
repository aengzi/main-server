<?php

namespace Database\Seeds;

use App\Models\PwdReset;
use Illuminate\Database\Seeder;

class PwdResetSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            PwdReset::factory()->create();
        }
    }
}
