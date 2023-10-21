<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LolTimelineSeeder extends Seeder
{
    public function run(): void
    {
        DB::unprepared(
            file_get_contents(
                base_path('.docker/mysql/lol_timelines.sql')
            )
        );
    }
}
