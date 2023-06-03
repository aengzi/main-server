<?php

namespace Database\Seeds;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            Notification::factory()->create();
        }
    }
}
