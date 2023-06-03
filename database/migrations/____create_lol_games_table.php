<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLolGamesTable extends Migration
{
    public function down()
    {
        Schema::drop('lol_games');
    }

    public function up()
    {
        Schema::create('lol_games', function (Blueprint $table) {
            $table
                ->bigInteger('id')
                ->unsigned()
            ;
            $table
                ->integer('vod_id')
                ->unsigned()
                ->nullable()
            ;
            $table
                ->string('account_id')
                ->nullable()
            ;
            $table
                ->text('matches')
                ->nullable()
            ;
            $table
                ->mediumText('timelines')
                ->nullable()
            ;
            $table
                ->timestamp('created_at', 3)
                ->nullable()
                ->comment('utc+09:00')
            ;
            $table
                ->string('participant_id')
                ->nullable()
            ;
            $table
                ->string('time_sh_file_id')
                ->nullable()
            ;
            $table
                ->timestamp('time_sh_at', 3)
                ->nullable()
            ;
            $table
                ->binary('time_sh_img')
                ->nullable()
            ;
            $table
                ->smallInteger('time_sh_elapsed_sec')
                ->nullable()
            ;
            $table
                ->timestamp('started_at', 3)
                ->nullable()
            ;

            $table
                ->primary('id')
            ;
            $table
                ->unique('started_at')
            ;
            $table
                ->index('participant_id')
            ;
            $table
                ->index([DB::raw('timelines(1)')])
            ;
            $table
                ->index([DB::raw('matches(1)')])
            ;
            $table
                ->index('created_at')
            ;
            $table
                ->index('time_sh_at')
            ;
            $table
                ->index('time_sh_file_id')
            ;
            $table
                ->index('vod_id')
            ;
        });
    }
}
