<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVodsTable extends Migration
{
    public function down()
    {
        Schema::drop('vods');
    }

    public function up()
    {
        Schema::create('vods', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->integer('bcast_id')
                ->unsigned()
            ;
            $table
                ->string('related_type')
            ;
            $table
                ->integer('related_id')
                ->unsigned()
            ;
            $table
                ->string('title')
            ;
            $table
                ->longText('data')
                ->nullable()
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
                ->decimal('duration', 10, 3)
                ->nullable()
            ;
            $table
                ->timestamp('started_at', 3)
                ->nullable()
            ;
            $table
                ->timestamp('ended_at', 3)
                ->nullable()
            ;

            $table
                ->index('bcast_id')
            ;
            $table
                ->index('title')
            ;
            $table
                ->index('duration')
            ;
            $table
                ->index([DB::raw('data(1)')])
            ;
            $table
                ->index('related_id')
            ;
            $table
                ->index('related_type')
            ;
        });
    }
}
