<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAftvBcastsTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_bcasts');
    }

    public function up()
    {
        Schema::create('aftv_bcasts', function (Blueprint $table) {
            $table
                ->integer('id')
                ->unsigned()
            ;
            $table
                ->string('bj_user_id')
            ;
            $table
                ->decimal('duration', 12, 3)
            ;
            $table
                ->timestamp('started_at')
            ;
            $table
                ->timestamp('ended_at')
            ;
            $table
                ->string('gdrive_id')
                ->nullable()
            ;

            $table
                ->primary('id')
            ;
            $table
                ->unique('gdrive_id')
            ;
        });
    }
}
