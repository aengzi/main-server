<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYtbCommentRepliesTable extends Migration
{
    public function down()
    {
        Schema::drop('ytb_comment_replies');
    }

    public function up()
    {
        Schema::create('ytb_comment_replies', function (Blueprint $table) {
            $table
                ->string('id')
            ;
            $table
                ->string('etag')
            ;
            $table
                ->string('thread_id')
            ;
            $table
                ->string('author_name')
            ;
            $table
                ->string('author_img_url')
            ;
            $table
                ->string('author_channel_id')
            ;
            $table
                ->text('text')
                ->nullable()
            ;
            $table
                ->mediumInteger('like_count')
                ->unsigned()
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
                ->primary('id')
            ;
            $table
                ->index('thread_id')
            ;
            $table
                ->index('created_at')
            ;
        });
    }
}
