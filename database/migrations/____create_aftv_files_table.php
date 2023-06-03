<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAftvFilesTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_files');
    }

    public function up()
    {
        Schema::create('aftv_files', function (Blueprint $table) {
            $table
                ->integer('bcast_id')
                ->unsigned()
            ;
            $table
                ->smallInteger('m3u8_index')
                ->unsigned()
            ;
            $table
                ->mediumInteger('file_index')
                ->unsigned()
            ;
            $table
                ->decimal('duration', 6, 3)
            ;
            $table
                ->timestamp('started_at')
                ->nullable()
            ;
            $table
                ->timestamp('ended_at')
                ->nullable()
            ;
            $table
                ->string('gdrive_id')
                ->nullable()
            ;

            $table
                ->primary(['bcast_id', 'm3u8_index', 'file_index'], 'id')
            ;
            $table
                ->index('started_at')
            ;
            $table
                ->index('ended_at')
            ;
            $table
                ->index(['started_at', 'ended_at'])
            ;
        });
    }
}
