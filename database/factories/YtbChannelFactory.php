<?php

namespace Database\Factories;

use Database\Factory;

class YtbChannelFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'title' => $this->faker->sentence(),
        ];
    }
}
