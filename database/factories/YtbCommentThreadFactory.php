<?php

namespace Database\Factories;

use Database\Factory;

class YtbCommentThreadFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'etag' => $this->faker->asciify('**************************'),
            'video_id' => $this->faker->randomNumber(8),
            'text' => $this->faker->text,
            'like_count' => $this->faker->randomNumber(2),
            'author_name' => $this->faker->name,
            'author_img_url' => $this->faker->url,
            'author_channel_id' => $this->faker->uuid,
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear('+1 year'),
        ];
    }
}
