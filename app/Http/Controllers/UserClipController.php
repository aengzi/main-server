<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Clip\UserClipCreatingService;

class UserClipController extends Controller
{
    public static function store()
    {
        return [UserClipCreatingService::class, [
            'end_sec' => static::input('end_sec'),
            'start_sec' => static::input('start_sec'),
            'title' => static::input('title'),
            'vod_id' => static::input('vod_id'),
        ], [
            'end_sec' => '[end_sec]',
            'start_sec' => '[start_sec]',
            'title' => '[title]',
            'vod_id' => '[vod_id]',
        ]];
    }
}
