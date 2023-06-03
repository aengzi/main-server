<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePwdResetsTable extends Migration
{
    public function down()
    {
        Schema::drop('pwd_resets');
    }

    public function up()
    {
        Schema::create('pwd_resets', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->string('email')
            ;
            $table
                ->string('token')
            ;
            $table
                ->tinyInteger('complete')
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
                ->index('email')
            ;
        });
    }
}
