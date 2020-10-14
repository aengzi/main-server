<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\YtbCommentReply\YtbCommentReplyPagingService;

class YtbCommentReplyController extends Controller
{
    public function index()
    {
        return [YtbCommentReplyPagingService::class, [
            'cursor_id'
                => $this->input('cursor_id'),
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'limit'
                => $this->input('limit'),
            'order_by'
                => $this->input('order_by'),
            'thread_id'
                => $this->input('thread_id'),
        ], [
            'cursor_id'
                => '[cursor_id]',
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'limit'
                => '[limit]',
            'order_by'
                => '[order_by]',
            'thread_id'
                => '[thread_id]'
        ]];
    }
}
