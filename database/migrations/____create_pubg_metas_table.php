<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePubgMetasTable extends Migration
{
    public function down()
    {
        Schema::drop('pubg_metas');
    }

    public function up()
    {
        Schema::create('pubg_metas', function (Blueprint $table) {
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
                ->string('property')
            ;
            $table
                ->string('value')
            ;

            $table
                ->index('game_id')
            ;
            $table
                ->index(['property', 'value'])
            ;
        });
    }
}
