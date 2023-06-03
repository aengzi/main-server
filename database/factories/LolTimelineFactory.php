<?php

namespace Database\Factories;

use Database\Factory;

class LolTimelineFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'game_id' => $this->faker->randomNumber(8),
            'type' => $this->faker->word,
            'elapsed_timestamp' => $this->faker->randomNumber(3),
        ];
    }
}
