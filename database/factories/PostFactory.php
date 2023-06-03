<?php

namespace Database\Factories;

use Database\Factory;

class PostFactory extends Factory
{
    public function definition()
    {
        return [
            // 'id',
            'user_id' => $this->faker->randomNumber(8),
            'like_count' => $this->faker->randomNumber(2),
            'dislike_count' => $this->faker->randomNumber(2),
            'thread_count' => $this->faker->randomNumber(2),
            'type' => $this->faker->word,
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->sentence,
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear('+1 year'),
        ];
    }
}
