<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleClientsTable extends Migration
{
    public function down()
    {
        Schema::drop('google_clients');
    }

    public function up()
    {
        Schema::create('google_clients', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->string('user')
            ;
            $table
                ->text('credential')
            ;
            $table
                ->text('access_token')
            ;
        });
    }
}
