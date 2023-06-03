<?php

namespace Database\Factories;

use Database\Factory;

class AftvIpFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'ip' => $this->faker->localIpv4,
        ];
    }
}
