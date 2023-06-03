<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAftvTagsTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_tags');
    }

    public function up()
    {
        Schema::create('aftv_tags', function (Blueprint $table) {
            $table
                ->increments('id')
            ;
            $table
                ->string('title')
            ;
            $table
                ->integer('priority')
                ->unsigned()
            ;

            $table
                ->unique('title')
            ;
            $table
                ->index('priority')
            ;
        });
    }
}
