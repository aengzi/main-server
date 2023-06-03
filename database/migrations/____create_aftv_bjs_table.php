<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAftvBjsTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_bjs');
    }

    public function up()
    {
        Schema::create('aftv_bjs', function (Blueprint $table) {
            $table
                ->string('id')
            ;
            $table
                ->string('nick')
            ;
            $table
                ->integer('station_id')
                ->unsigned()
            ;
            $table
                ->integer('bbs_id')
                ->unsigned()
            ;
            $table
                ->string('gdrive_id')
                ->nullable()
            ;

            $table
                ->unique('id')
            ;
            $table
                ->unique('station_id')
            ;
            $table
                ->unique('bbs_id')
            ;
            $table
                ->unique('gdrive_id')
            ;
        });
    }
}
