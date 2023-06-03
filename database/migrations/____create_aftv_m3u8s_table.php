<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAftvM3u8sTable extends Migration
{
    public function down()
    {
        Schema::drop('aftv_m3u8s');
    }

    public function up()
    {
        Schema::create('aftv_m3u8s', function (Blueprint $table) {
            $table
                ->integer('review_id')
                ->unsigned()
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
                ->string('file_prefix')
                ->nullable()
            ;
            $table
                ->string('url')
                ->nullable()
            ;
            $table
                ->string('ts_path')
                ->nullable()
            ;
            $table
                ->string('play_path')
                ->nullable()
            ;
            $table
                ->mediumText('play_data')
                ->nullable()
            ;
            $table
                ->longText('data')
                ->nullable()
            ;
            $table
                ->string('resolution')
                ->nullable()
            ;
            $table
                ->integer('ts_count')
                ->nullable()
            ;
            $table
                ->decimal('duration', 10, 3)
                ->nullable()
            ;
            $table
                ->string('gdrive_id')
                ->nullable()
            ;
            $table
                ->string('validation')
                ->nullable()
            ;

            $table
                ->unique(['bcast_id', 'm3u8_index'], 'id')
            ;
            $table
                ->unique('gdrive_id')
            ;
            $table
                ->index('ts_count')
            ;
            $table
                ->index('review_id')
            ;
            $table
                ->index('url')
            ;
            $table
                ->index('ts_path')
            ;
            $table
                ->index('play_path')
            ;
            $table
                ->index([DB::raw('play_data(1)')])
            ;
            $table
                ->index([DB::raw('data(1)')])
            ;
            $table
                ->index('duration')
            ;
            $table
                ->index('resolution')
            ;
            $table
                ->index('file_prefix')
            ;
            $table
                ->index('validation')
            ;
        });
    }
}
