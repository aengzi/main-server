<?php

namespace Database\Factories;

use Database\Factory;

class PwdResetFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'email' => $this->faker->email,
            'token' => $this->faker->asciify('*******************************'),
            'complete' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear('+1 year'),
        ];
    }
}
