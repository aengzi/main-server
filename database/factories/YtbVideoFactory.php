<?php

namespace Database\Factories;

use Database\Factory;

class YtbVideoFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'ytb_id' => $this->faker->randomNumber(8),
            'like_count' => $this->faker->randomNumber(2),
            'channel_id' => $this->faker->uuid,
            'title' => $this->faker->sentence,
            'created_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
