<?php

namespace Database\Factories;

use Database\Factory;

class VodFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'related_id' => $this->faker->randomNumber(8),
            'related_type' => $this->faker->word,
            'data' => $this->faker->text,
            'title' => $this->faker->sentence,
            'like_count' => $this->faker->randomNumber(2),
            'thread_count' => $this->faker->randomNumber(2),
            'bcast_id' => $this->faker->randomNumber(8),
            'duration' => $this->faker->randomFloat(3),
            'started_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'ended_at' => $this->faker->dateTimeBetween('now', '+1 day'),
        ];
    }
}
