<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYtbChannelsTable extends Migration
{
    public function down()
    {
        Schema::drop('ytb_channels');
    }

    public function up()
    {
        Schema::create('ytb_channels', function (Blueprint $table) {
            $table
                ->string('id')
                ->comment('youtube id')
            ;
            $table
                ->string('title')
            ;

            $table
                ->primary('id')
            ;
        });
    }
}
