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
    public function destroy()
    {
        return [PostDeletingService::class, [
            'id'
                => Request::route('id'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'id'
                => Request::route('id'),
            'token'
                => 'header[authorization]'
        ]];
    }

    public function index()
    {
        return [PostPagingService::class, [
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
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass,
            'type'
                => $this->input('type'),
            'user_id'
                => $this->input('user_id')
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
            'token'
                => 'header[authorization]',
            'type'
                => '[type]',
            'user_id'
                => '[user_id]',
        ]];
    }

    public function show()
    {
        return [PostFindingService::class, [
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'id'
                => Request::route('id'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'id'
                => Request::route('id'),
            'token'
                => 'header[authorization]'
        ]];
    }

    public function store()
    {
        return [PostCreatingService::class, [
            'content'
                => $this->input('content'),
            'title'
                => $this->input('title'),
            'type'
                => $this->input('type'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'content'
                => '[content]',
            'title'
                => '[title]',
            'type'
                => '[type]',
            'token'
                => 'header[authorization]'
        ]];
    }

    public function update()
    {
        return [PostUpdatingService::class, [
            'content'
                => $this->input('content'),
            'title'
                => $this->input('title'),
            'type'
                => $this->input('type'),
            'id'
                => Request::route('id'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'content'
                => '[content]',
            'title'
                => '[title]',
            'type'
                => '[type]',
            'id'
                => Request::route('id'),
            'token'
                => 'header[authorization]'
        ]];
    }
}
