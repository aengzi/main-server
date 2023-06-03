<?php

namespace Database\Factories;

use Database\Factory;

class PubgGameFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomNumber(8, false),
            'vod_id' => $this->faker->randomNumber(8),
            'match_id' => $this->faker->randomNumber(8),
            'participant_id' => $this->faker->randomNumber(8),
            'started_at' => $this->faker->dateTimeThisYear(),
            'offset' => $this->faker->randomNumber(2),
            'summary' => $this->faker->sentence,
            'matches' => null,
            'deaths' => null,
        ];
    }
}
