<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\YtbCommentReply\YtbCommentReplyPagingService;

class YtbCommentReplyController extends Controller
{
    public static function index()
    {
        return [YtbCommentReplyPagingService::class, [
            'thread_id' => static::input('thread_id'),
        ], [
            'thread_id' => '[thread_id]',
        ]];
    }
}
