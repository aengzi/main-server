<?php

namespace Database\Factories;

use Database\Factory;

class LolGameFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomNumber(8, false),
            'vod_id' => $this->faker->randomNumber(8),
            'account_id' => $this->faker->randomNumber(8),
            'matches' => null,
            'timelines' => null,
            'created_at' => $this->faker->dateTimeThisYear(),
            'started_at' => $this->faker->dateTimeThisYear(),
            'participant_id' => $this->faker->randomNumber(8),
            'time_sh_file_id' => $this->faker->randomNumber(8),
            'time_sh_at' => $this->faker->dateTimeThisYear(),
            'time_sh_img' => null,
            'time_sh_elapsed_sec' => null,
        ];
    }
}
