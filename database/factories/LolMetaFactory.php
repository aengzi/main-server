<?php

namespace Database\Factories;

use Database\Factory;

class LolMetaFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'game_id' => $this->faker->randomNumber(8),
            'property' => $this->faker->word,
            'value' => $this->faker->word,
        ];
    }
}
