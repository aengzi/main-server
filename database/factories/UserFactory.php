<?php

namespace Database\Factories;

use Database\Factory;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'nick' => $this->faker->unique()->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
            'has_thumbnail' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'),
        ];
    }
}
