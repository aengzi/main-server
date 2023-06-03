<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYtbVideosTable extends Migration
{
    public function down()
    {
        Schema::drop('ytb_videos');
    }

    public function up()
    {
        Schema::create('ytb_videos', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->string('ytb_id')
            ;
            $table
                ->string('channel_id')
            ;
            $table
                ->mediumInteger('like_count')
                ->unsigned()
            ;
            $table
                ->mediumInteger('thread_count')
                ->unsigned()
            ;
            $table
                ->string('title')
            ;
            $table
                ->timestamp('created_at')
                ->nullable()
            ;

            $table
                ->unique('ytb_id')
            ;
            $table
                ->index('created_at')
            ;
        });
    }
}
