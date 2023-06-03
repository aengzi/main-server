<?php

namespace Database\Factories;

use Database\Factory;

class LolChampionFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'key' => $this->faker->word,
            'name' => $this->faker->word,
        ];
    }
}
