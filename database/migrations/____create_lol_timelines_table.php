<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLolTimelinesTable extends Migration
{
    public function down()
    {
        Schema::drop('lol_timelines');
    }

    public function up()
    {
        Schema::create('lol_timelines', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->bigInteger('game_id')
                ->unsigned()
            ;
            $table
                ->string('type')
            ;
            $table
                ->integer('elapsed_timestamp')
                ->unsigned()
                ->nullable()
            ;

            $table
                ->index('game_id')
            ;
            $table
                ->index('type')
            ;
            $table
                ->index('elapsed_timestamp')
            ;
        });
    }
}
