<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Clip\TempClipCreatingService;
use Illuminate\Support\Facades\Request;

class TempClipController extends Controller
{
    public static function store()
    {
        return [TempClipCreatingService::class, [
            'start_sec'
                => static::input('start_sec'),
            'end_sec'
                => static::input('end_sec'),
            'vod_id'
                => static::input('vod_id')
        ], [
            'start_sec'
                => '[start_sec]',
            'end_sec'
                => '[end_sec]',
            'vod_id'
                => '[vod_id]'
        ]];
    }
}
