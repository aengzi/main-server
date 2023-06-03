<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLolMetasTable extends Migration
{
    public function down()
    {
        Schema::drop('lol_metas');
    }

    public function up()
    {
        Schema::create('lol_metas', function (Blueprint $table) {
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
