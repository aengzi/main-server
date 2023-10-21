<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VodSeeder extends Seeder
{
    public function run(): void
    {
        DB::unprepared(
            file_get_contents(
                base_path('.docker/mysql/vods(lol_game).sql')
            )
        );
        DB::unprepared(
            file_get_contents(
                base_path('.docker/mysql/vods(pubg_game).sql')
            )
        );
    }
}
