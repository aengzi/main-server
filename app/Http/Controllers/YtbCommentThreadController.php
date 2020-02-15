<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\YtbCommentThread\YtbCommentThreadPagingService;

class YtbCommentThreadController extends Controller
{
    public function index()
    {
        return [YtbCommentThreadPagingService::class, [
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'limit'
                => $this->input('limit'),
            'page'
                => $this->input('page'),
            'order_by'
                => $this->input('order_by'),
            'video_id'
                => $this->input('video_id')
        ], [
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'limit'
                => '[limit]',
            'page'
                => '[page]',
            'order_by'
                => '[order_by]',
            'video_id'
                => '[video_id]'
        ]];
    }
}
