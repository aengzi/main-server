<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Post\PostPagingService;
use App\Services\Post\PostDeletingService;
use App\Services\Post\PostCreatingService;
use App\Services\Post\PostFindingService;
use App\Services\Post\PostUpdatingService;
use Illuminate\Support\Facades\Request;

class PostController extends Controller
{
    public static function destroy()
    {
        return [PostDeletingService::class];
    }

    public static function index()
    {
        return [PostPagingService::class, [
            'type'
                => static::input('type'),
            'user_id'
                => static::input('user_id')
        ], [
            'type'
                => '[type]',
            'user_id'
                => '[user_id]',
        ]];
    }

    public static function show()
    {
        return [PostFindingService::class];
    }

    public static function store()
    {
        return [PostCreatingService::class, [
            'content'
                => static::input('content'),
            'title'
                => static::input('title'),
            'type'
                => static::input('type'),
        ], [
            'content'
                => '[content]',
            'title'
                => '[title]',
            'type'
                => '[type]',
        ]];
    }

    public static function update()
    {
        return [PostUpdatingService::class, [
            'content'
                => static::input('content'),
            'title'
                => static::input('title'),
            'type'
                => static::input('type'),
        ], [
            'content'
                => '[content]',
            'title'
                => '[title]',
            'type'
                => '[type]',
        ]];
    }
}
