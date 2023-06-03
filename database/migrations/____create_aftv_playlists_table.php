<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAftvPlaylistsTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_playlists');
    }

    public function up()
    {
        Schema::create('aftv_playlists', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
            ;
            $table
                ->string('type')
            ;
            $table
                ->string('title')
            ;

            $table
                ->primary('id')
            ;
            $table
                ->unique('title')
            ;
        });
    }
}
