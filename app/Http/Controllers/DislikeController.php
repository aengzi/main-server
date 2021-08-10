<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Dislike\DislikeCreatingService;
use App\Services\Dislike\DislikeDeletingService;
use App\Services\Dislike\DislikePagingService;
use Illuminate\Support\Facades\Request;

class DislikeController extends Controller
{
    public static function destroy()
    {
        return [DislikeDeletingService::class, [
            'dislike_id' => Request::route('id'),
        ], [
            'dislike_id' => Request::route('id'),
        ]];
    }

    public static function index()
    {
        return [DislikePagingService::class, [
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
        return [DislikeCreatingService::class, [
            'related_id' => static::input('related_id'),
            'related_type' => static::input('related_type'),
        ], [
            'related_id' => '[related_id]',
            'related_type' => '[related_type]',
        ]];
    }
}
