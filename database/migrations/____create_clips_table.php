<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClipsTable extends Migration
{
    public function down()
    {
        Schema::drop('clips');
    }

    public function up()
    {
        Schema::create('clips', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->integer('user_id')
                ->unsigned()
            ;
            $table
                ->timestamp('created_at')
                ->default(app('db')->raw('CURRENT_TIMESTAMP'))
            ;

            $table
                ->index('user_id')
            ;
            $table
                ->index('created_at')
            ;
        });
    }
}
