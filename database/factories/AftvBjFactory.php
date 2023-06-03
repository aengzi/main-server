<?php

namespace Database\Factories;

use Database\Factory;

class AftvBjFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->asciify('********'),
            'nick' => $this->faker->unique()->word,
            'station_id' => $this->faker->unique()->randomNumber(8, false),
            'bbs_id' => $this->faker->unique()->randomNumber(8, false),
            'gdrive_id' => $this->faker->uuid,
        ];
    }
}
