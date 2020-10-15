<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\CommentThread\CommentThreadCreatingService;
use App\Services\CommentThread\CommentThreadDeletingService;
use App\Services\CommentThread\CommentThreadPagingService;
use App\Services\CommentThread\CommentThreadUpdatingService;
use Illuminate\Support\Facades\Request;

class CommentThreadController extends Controller
{
    public static function destroy()
    {
        return [CommentThreadDeletingService::class];
    }

    public static function index()
    {
        return [CommentThreadPagingService::class, [
            'related_id'
                => static::input('related_id'),
            'related_type'
                => static::input('related_type'),
            'user_id'
                => static::input('user_id'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'user_id'
                => '[user_id]',
        ]];
    }

    public static function store()
    {
        return [CommentThreadCreatingService::class, [
            'related_id'
                => static::input('related_id'),
            'related_type'
                => static::input('related_type'),
            'message'
                => static::input('message'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'message'
                => '[message]',
        ]];
    }

    public static function update()
    {
        return [CommentThreadUpdatingService::class, [
            'message'
                => static::input('message'),
        ], [
            'message'
                => '[message]',
        ]];
    }
}
