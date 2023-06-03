<?php

namespace Database\Factories;

use Database\Factory;

class NotificationFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'type' => $this->faker->word,
            'description' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
