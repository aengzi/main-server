<?php

namespace Database\Factories;

use Database\Factory;

class AftvM3u8Factory extends Factory
{
    public function definition()
    {
        return [
            'review_id' => $this->faker->randomNumber(8),
            'bcast_id' => $this->faker->randomNumber(8),
            'm3u8_index' => $this->faker->randomNumber(1),
            'file_prefix' => null,
            'url' => null,
            'ts_path' => null,
            'play_path' => null,
            'play_data' => null,
            'data' => null,
            'resolution' => null,
            'ts_count' => $this->faker->randomNumber(3),
            'duration' => $this->faker->randomFloat(3),
            'gdrive_id' => $this->faker->uuid,
            'validation' => null,
        ];
    }
}
