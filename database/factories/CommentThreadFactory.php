<?php

namespace Database\Factories;

use Database\Factory;

class CommentThreadFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'user_id' => $this->faker->randomNumber(8),
            'related_id' => $this->faker->randomNumber(8),
            'related_type' => $this->faker->word,
            'like_count' => $this->faker->randomNumber(2),
            'dislike_count' => $this->faker->randomNumber(2),
            'reply_count' => $this->faker->randomNumber(2),
            'message' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear('+1 year'),
        ];
    }
}
