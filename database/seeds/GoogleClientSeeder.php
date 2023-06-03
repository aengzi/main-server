<?php

namespace Database\Seeds;

use App\Models\GoogleClient;
use Illuminate\Database\Seeder;

class GoogleClientSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            GoogleClient::factory()->create();
        }
    }
}
