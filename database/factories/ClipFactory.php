<?php

namespace Database\Factories;

use Database\Factory;

class ClipFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'user_id' => $this->faker->randomNumber(8),
            'created_at' => $this->faker->dateTimeThisDecade(),
        ];
    }
}
