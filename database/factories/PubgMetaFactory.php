<?php

namespace Database\Factories;

use Database\Factory;

class PubgMetaFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'game_id' => $this->faker->uuid,
            'property' => $this->faker->word,
            'value' => $this->faker->word,
        ];
    }
}
