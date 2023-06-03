<?php

namespace Database\Factories;

use Database\Factory;

class AftvFileFactory extends Factory
{
    public function definition()
    {
        return [
            'bcast_id' => $this->faker->randomNumber(5, false),
            'm3u8_index' => $this->faker->randomFloat(1),
            'file_index' => $this->faker->randomFloat(3),
            'duration' => $this->faker->randomFloat(3),
            'started_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'ended_at' => $this->faker->dateTimeBetween('now', '+1 day'),
            'gdrive_id' => $this->faker->uuid,
        ];
    }
}
