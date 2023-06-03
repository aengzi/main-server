<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePubgGamesTable extends Migration
{
    public function down()
    {
        Schema::drop('pubg_games');
    }

    public function up()
    {
        Schema::create('pubg_games', function (Blueprint $table) {
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
                ->string('offset')
            ;
            $table
                ->string('match_id')
            ;
            $table
                ->string('participant_id')
            ;
            $table
                ->text('summary')
            ;
            $table
                ->mediumText('matches')
                ->nullable()
            ;
            $table
                ->mediumText('deaths')
                ->nullable()
            ;
            $table
                ->dateTime('started_at')
            ;

            $table
                ->primary('id')
            ;
            $table
                ->index('vod_id')
            ;
            $table
                ->index('started_at')
            ;
            $table
                ->unique('participant_id')
            ;
            $table
                ->unique('match_id')
            ;
            $table
                ->index([DB::raw('matches(1)')])
            ;
            $table
                ->index([DB::raw('deaths(1)')])
            ;
        });
    }
}
