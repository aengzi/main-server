<?php

namespace Database\Factories;

use Database\Factory;

class CommentReplyFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'user_id' => $this->faker->randomNumber(8),
            'thread_id' => $this->faker->randomNumber(8),
            'message' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear('+1 year'),
        ];
    }
}
