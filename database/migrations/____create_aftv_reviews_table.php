<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAftvReviewsTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_reviews');
    }

    public function up()
    {
        Schema::create('aftv_reviews', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
            ;
            $table
                ->string('bj_user_id')
            ;
            $table
                ->integer('bcast_id')
                ->unsigned()
                ->nullable()
            ;
            $table
                ->text('info')
                ->nullable()
            ;
            $table
                ->smallInteger('m3u8_count')
                ->unsigned()
                ->nullable()
            ;
            $table
                ->decimal('duration', 12, 3)
                ->nullable()
            ;
            $table
                ->integer('playlist_id')
                ->unsigned()
                ->nullable()
            ;
            $table
                ->dateTime('registered_at')
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
                ->primary('id')
            ;
            $table
                ->index('bcast_id')
            ;
            $table
                ->index('bj_user_id')
            ;
            $table
                ->index([DB::raw('info(1)')])
            ;
            $table
                ->index('duration')
            ;
            $table
                ->index('registered_at')
            ;
            $table
                ->index('started_at')
            ;
            $table
                ->index('ended_at')
            ;
        });
    }
}
