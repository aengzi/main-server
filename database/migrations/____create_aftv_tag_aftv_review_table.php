<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAftvTagAftvReviewTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_tag_aftv_review');
    }

    public function up()
    {
        Schema::create('aftv_tag_aftv_review', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->integer('tag_id')
                ->unsigned()
            ;
            $table
                ->string('tag_name')
            ;
            $table
                ->integer('review_id')
                ->unsigned()
            ;

            $table
                ->index('tag_id')
            ;
            $table
                ->index('review_id')
            ;
        });
    }
}
