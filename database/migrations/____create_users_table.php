<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function down()
    {
        Schema::drop('users');
    }

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table
                ->bigInteger('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->string('nick')
            ;
            $table
                ->string('email')
            ;
            $table
                ->string('password')
            ;
            $table
                ->boolean('has_thumbnail')
            ;
            $table
                ->timestamp('created_at')
                ->default(app('db')->raw('CURRENT_TIMESTAMP'))
            ;

            $table
                ->unique('nick')
            ;
        });
    }
}
