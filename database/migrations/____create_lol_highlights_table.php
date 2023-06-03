<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLolHighlightsTable extends Migration
{
    public function down()
    {
        Schema::drop('lol_highlights');
    }

    public function up()
    {
        Schema::create('lol_highlights', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->bigInteger('lol_timeline_id')
                ->unsigned()
                ->nullable()
            ;
            $table
                ->string('title')
            ;
            $table
                ->longText('data')
                ->nullable()
            ;

            $table
                ->unique('lol_timeline_id')
            ;
            $table
                ->index([DB::raw('data(1)')])
            ;
            $table
                ->index('title')
            ;
        });
    }
}
