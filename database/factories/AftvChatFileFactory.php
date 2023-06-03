<?php

namespace Database\Factories;

use Database\Factory;

class AftvChatFileFactory extends Factory
{
    public function definition()
    {
        return [
            'key_id' => $this->faker->randomNumber(5, false),
            'bcast_id' => $this->faker->randomNumber(5, false),
            'm3u8_index' => $this->faker->randomNumber(5, false),
            'offset_sec' => $this->faker->numberBetween(0, 100),
            'data' => $this->faker->sentence,
        ];
    }
}
