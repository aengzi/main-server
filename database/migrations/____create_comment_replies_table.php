<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCommentRepliesTable extends Migration
{
    public function down()
    {
        Schema::drop('comment_replies');
    }

    public function up()
    {
        Schema::create('comment_replies', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->integer('thread_id')
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
                ->timestamp('created_at', 6)
                ->default(DB::raw('CURRENT_TIMESTAMP(6)'))
            ;
            $table
                ->timestamp('updated_at', 6)
                ->default(DB::raw('CURRENT_TIMESTAMP(6)'))
            ;

            $table
                ->index('thread_id')
            ;
            $table
                ->index('user_id')
            ;
        });
    }
}
