<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Like\LikePagingService;
use App\Services\Like\LikeCreatingService;
use App\Services\Like\LikeDeletingService;
use Illuminate\Support\Facades\Request;

class LikeController extends Controller
{
    public function destroy()
    {
        return [LikeDeletingService::class, [
            'like_id'
                => Request::route('id'),
        ], [
            'like_id'
                => Request::route('id'),
        ]];
    }

    public function index()
    {
        return [LikePagingService::class, [
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
            'related_types'
                => $this->input('related_types'),
            'user_id'
                => $this->input('user_id'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'related_types'
                => '[related_types]',
            'user_id'
                => '[user_id]',
        ]];
    }

    public function store()
    {
        return [LikeCreatingService::class, [
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
        ]];
    }
}
