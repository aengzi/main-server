<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\YtbCommentReply\YtbCommentReplyPagingService;

class YtbCommentReplyController extends Controller
{
    public function index()
    {
        return [YtbCommentReplyPagingService::class, [
            'thread_id'
                => $this->input('thread_id'),
        ], [
            'thread_id'
                => '[thread_id]'
        ]];
    }
}
