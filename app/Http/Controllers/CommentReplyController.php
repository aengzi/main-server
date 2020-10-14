<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\CommentReply\CommentReplyCreatingService;
use App\Services\CommentReply\CommentReplyDeletingService;
use App\Services\CommentReply\CommentReplyPagingService;
use App\Services\CommentReply\CommentReplyUpdatingService;
use Illuminate\Support\Facades\Request;

class CommentReplyController extends Controller
{
    public function destroy()
    {
        return [CommentReplyDeletingService::class, [
            'id'
                => Request::route('id'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : ''
        ], [
            'id'
                => Request::route('id'),
            'token'
                => 'header[authorization]'
        ]];
    }

    public function index()
    {
        return [CommentReplyPagingService::class, [
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
            'token'
                => Request::bearerToken() ? Request::bearerToken() : ''
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
                => '[thread_id]',
            'token'
                => 'header[authorization]'
        ]];
    }

    public function store()
    {
        return [CommentReplyCreatingService::class, [
            'thread_id'
                => $this->input('thread_id'),
            'message'
                => $this->input('message'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : '',
        ], [
            'thread_id'
                => '[thread_id]',
            'message'
                => '[message]',
            'token'
                => 'header[authorization]'
        ]];
    }

    public function update()
    {
        return [CommentReplyUpdatingService::class, [
            'id'
                => Request::route('id'),
            'message'
                => $this->input('message'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : ''
        ], [
            'id'
                => Request::route('id'),
            'message'
                => '[message]',
            'token'
                => 'header[authorization]'
        ]];
    }
}
