<?php

namespace Database\Factories;

use Database\Factory;

class LolChampionFactory extends Factory
{
    public function definition()
    {
        $key = $this->faker->unique()->lexify();

        return [
            // 'id',
            'key' => $key,
            'name' => $key,
        ];
    }
}
