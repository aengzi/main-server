<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    public function down()
    {
        Schema::drop('devices');
    }

    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
                ->autoIncrement()
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
                ->timestamp('updated_at', 6)
                ->default(DB::raw('CURRENT_TIMESTAMP(6)'))
            ;

            $table
                ->index(['related_type', 'related_id'])
            ;
        });
    }
}
