<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAftvIpsTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_ips');
    }

    public function up()
    {
        Schema::create('aftv_ips', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
            ;
            $table
                ->string('ip')
            ;

            $table
                ->index('ip')
            ;
        });
    }
}
