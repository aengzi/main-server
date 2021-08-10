<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\YtbCommentThread\YtbCommentThreadPagingService;

class YtbCommentThreadController extends Controller
{
    public static function index()
    {
        return [YtbCommentThreadPagingService::class, [
            'video_id' => static::input('video_id'),
        ], [
            'video_id' => '[video_id]',
        ]];
    }
}
