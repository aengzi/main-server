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
        return [CommentReplyDeletingService::class];
    }

    public function index()
    {
        return [CommentReplyPagingService::class, [
            'thread_id'
                => $this->input('thread_id'),
        ], [
            'thread_id'
                => '[thread_id]',
        ]];
    }

    public function store()
    {
        return [CommentReplyCreatingService::class, [
            'thread_id'
                => $this->input('thread_id'),
            'message'
                => $this->input('message'),
        ], [
            'thread_id'
                => '[thread_id]',
            'message'
                => '[message]',
        ]];
    }

    public function update()
    {
        return [CommentReplyUpdatingService::class, [
            'message'
                => $this->input('message'),
        ], [
            'message'
                => '[message]',
        ]];
    }
}
