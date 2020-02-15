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
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'like_id'
                => Request::route('id'),
            'token'
                => 'header[authorization]'
        ]];
    }

    public function index()
    {
        return [LikePagingService::class, [
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'limit'
                => $this->input('limit'),
            'order_by'
                => $this->input('order_by'),
            'page'
                => $this->input('page'),
            'user_id'
                => $this->input('user_id'),
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
            'related_types'
                => $this->input('related_types')
        ], [
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'limit'
                => '[limit]',
            'order_by'
                => '[order_by]',
            'page'
                => '[page]',
            'user_id'
                => '[user_id]',
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'related_types'
                => '[related_types]'
        ]];
    }

    public function store()
    {
        return [LikeCreatingService::class, [
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'token'
                => 'header[authorization]'
        ]];
    }
}
