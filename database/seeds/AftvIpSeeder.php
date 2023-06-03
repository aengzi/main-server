<?php

namespace Database\Seeds;

use App\Models\AftvIp;
use Illuminate\Database\Seeder;

class AftvIpSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            AftvIp::factory()->create();
        }
    }
}
