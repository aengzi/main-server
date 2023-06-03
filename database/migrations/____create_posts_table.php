<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function down()
    {
        Schema::drop('posts');
    }

    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->string('type')
            ;
            $table
                ->integer('user_id')
                ->unsigned()
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
                ->mediumInteger('thread_count')
                ->unsigned()
            ;
            $table
                ->string('title')
            ;
            $table
                ->mediumText('content')
            ;
            $table
                ->timestamp('created_at')
                ->nullable()
            ;
            $table
                ->timestamp('updated_at')
                ->nullable()
            ;

            $table
                ->index('user_id')
            ;
            $table
                ->index([DB::raw('content(1)')])
            ;
        });
    }
}
