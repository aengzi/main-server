<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCommentThreadsTable extends Migration
{
    public function down()
    {
        Schema::drop('comment_threads');
    }

    public function up()
    {
        Schema::create('comment_threads', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->string('related_type')
            ;
            $table
                ->integer('related_id')
                ->unsigned()
            ;
            $table
                ->integer('user_id')
                ->unsigned()
            ;
            $table
                ->text('message')
            ;
            $table
                ->mediumInteger('like_count')
                ->unsigned()
            ;
            $table
                ->mediumInteger('dislike_count')
                ->unsigned()
            ;
            $table
                ->mediumInteger('reply_count')
                ->unsigned()
            ;
            $table
                ->timestamp('created_at', 6)
                ->default(DB::raw('CURRENT_TIMESTAMP(6)'))
            ;
            $table
                ->timestamp('updated_at', 6)
                ->default(DB::raw('CURRENT_TIMESTAMP(6)'))
            ;

            $table
                ->index('related_id')
            ;
            $table
                ->index('user_id')
            ;
        });
    }
}
