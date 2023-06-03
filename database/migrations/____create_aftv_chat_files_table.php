<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAftvChatFilesTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_chat_files');
    }

    public function up()
    {
        Schema::create('aftv_chat_files', function (Blueprint $table) {
            $table
                ->string('key_id')
            ;
            $table
                ->integer('bcast_id')
                ->unsigned()
            ;
            $table
                ->smallInteger('m3u8_index')
                ->unsigned()
            ;
            $table
                ->integer('offset_sec')
                ->unsigned()
            ;
            $table
                ->longText('data')
            ;

            $table
                ->unique(['bcast_id', 'm3u8_index', 'offset_sec'], 'id')
            ;
            $table
                ->index([DB::raw('data(1)')])
            ;
            $table
                ->index('key_id')
            ;
            $table
                ->index('offset_sec')
            ;
        });
    }
}
