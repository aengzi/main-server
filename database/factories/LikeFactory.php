<?php

namespace Database\Factories;

use Database\Factory;

class LikeFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'user_id' => $this->faker->randomNumber(8),
            'related_id' => $this->faker->randomNumber(8),
            'related_type' => $this->faker->word,
            'created_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
