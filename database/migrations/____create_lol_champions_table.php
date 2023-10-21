<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLolChampionsTable extends Migration
{
    public function down()
    {
        Schema::drop('lol_champions');
    }

    public function up()
    {
        Schema::create('lol_champions', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
            ;
            $table
                ->string('key')
            ;
            $table
                ->string('name')
            ;
        });
    }
}
