<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDislikesTable extends Migration
{
    public function down()
    {
        Schema::drop('dislikes');
    }

    public function up()
    {
        Schema::create('dislikes', function (Blueprint $table) {
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
                ->string('related_type')
            ;
            $table
                ->integer('related_id')
                ->unsigned()
            ;
            $table
                ->timestamp('created_at', 6)
                ->default(DB::raw('CURRENT_TIMESTAMP(6)'))
            ;

            $table
                ->index('user_id')
            ;
            $table
                ->index('related_id')
            ;
            $table
                ->index('created_at')
            ;
        });
    }
}
