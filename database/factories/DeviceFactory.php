<?php

namespace Database\Factories;

use Database\Factory;

class DeviceFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'related_id' => $this->faker->randomNumber(8),
            'related_type' => $this->faker->word,
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear('+1 year'),
        ];
    }
}
