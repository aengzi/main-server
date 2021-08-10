<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\CommentReply\CommentReplyCreatingService;
use App\Services\CommentReply\CommentReplyDeletingService;
use App\Services\CommentReply\CommentReplyPagingService;
use App\Services\CommentReply\CommentReplyUpdatingService;

class CommentReplyController extends Controller
{
    public static function destroy()
    {
        return [CommentReplyDeletingService::class];
    }

    public static function index()
    {
        return [CommentReplyPagingService::class, [
            'thread_id' => static::input('thread_id'),
        ], [
            'thread_id' => '[thread_id]',
        ]];
    }

    public static function store()
    {
        return [CommentReplyCreatingService::class, [
            'thread_id' => static::input('thread_id'),
            'message' => static::input('message'),
        ], [
            'thread_id' => '[thread_id]',
            'message' => '[message]',
        ]];
    }

    public static function update()
    {
        return [CommentReplyUpdatingService::class, [
            'message' => static::input('message'),
        ], [
            'message' => '[message]',
        ]];
    }
}
