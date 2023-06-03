<?php

namespace Database\Factories;

use Database\Factory;

class AftvReviewFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomNumber(8, false),
            'bj_user_id' => $this->faker->word,
            'bcast_id' => $this->faker->randomNumber(5, false),
            'info' => $this->faker->sentence(),
            'm3u8_count' => $this->faker->randomNumber(1),
            'duration' => $this->faker->randomFloat(3),
            'bcast_id' => $this->faker->randomNumber(5, false),
            'registered_at' => $this->faker->dateTimeBetween('-2 day', '-1 day'),
            'started_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'ended_at' => $this->faker->dateTimeBetween('now', '+1 day'),
        ];
    }
}
