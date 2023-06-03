<?php

namespace Database\Factories;

use Database\Factory;

class PubgTimelineFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'game_id' => $this->faker->uuid,
            'type' => $this->faker->word,
            'elapsed_sec' => $this->faker->randomNumber(2),
        ];
    }
}
