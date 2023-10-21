<?php

namespace Database\Seeds;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            User::factory()->create();
        }
        User::factory()->create([
            'email' => 'dbwhddn10@gmail.com',
            'password' => 'jongwoo10!@',
        ]);
    }
}
