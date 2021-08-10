<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Like\LikeCreatingService;
use App\Services\Like\LikeDeletingService;
use App\Services\Like\LikePagingService;
use Illuminate\Support\Facades\Request;

class LikeController extends Controller
{
    public static function destroy()
    {
        return [LikeDeletingService::class, [
            'like_id' => Request::route('id'),
        ], [
            'like_id' => Request::route('id'),
        ]];
    }

    public static function index()
    {
        return [LikePagingService::class, [
            'related_id' => static::input('related_id'),
            'related_type' => static::input('related_type'),
            'related_types' => static::input('related_types'),
            'user_id' => static::input('user_id'),
        ], [
            'related_id' => '[related_id]',
            'related_type' => '[related_type]',
            'related_types' => '[related_types]',
            'user_id' => '[user_id]',
        ]];
    }

    public static function store()
    {
        return [LikeCreatingService::class, [
            'related_id' => static::input('related_id'),
            'related_type' => static::input('related_type'),
        ], [
            'related_id' => '[related_id]',
            'related_type' => '[related_type]',
        ]];
    }
}
