<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePubgTimelinesTable extends Migration
{
    public function down()
    {
        Schema::drop('pubg_timelines');
    }

    public function up()
    {
        Schema::create('pubg_timelines', function (Blueprint $table) {
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
                ->integer('elapsed_sec')
                ->unsigned()
            ;
        });
    }
}
