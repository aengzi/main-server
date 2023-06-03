<?php

namespace Database\Factories;

use Database\Factory;

class GoogleClientFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'user' => $this->faker->name,
            'credential' => $this->faker->sentence(),
            'access_token' => $this->faker->asciify('************************'),
        ];
    }
}
