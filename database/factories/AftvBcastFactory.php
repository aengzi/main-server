<?php

namespace Database\Factories;

use Database\Factory;

class AftvBcastFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomNumber(8, false),
            'bj_user_id' => $this->faker->word,
            'duration' => $this->faker->randomFloat(3),
            'started_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'ended_at' => $this->faker->dateTimeBetween('now', '+1 day'),
            'gdrive_id' => $this->faker->uuid,
        ];
    }
}
