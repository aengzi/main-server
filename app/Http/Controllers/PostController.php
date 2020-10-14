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
        return [PostDeletingService::class];
    }

    public function index()
    {
        return [PostPagingService::class, [
            'type'
                => $this->input('type'),
            'user_id'
                => $this->input('user_id')
        ], [
            'type'
                => '[type]',
            'user_id'
                => '[user_id]',
        ]];
    }

    public function show()
    {
        return [PostFindingService::class];
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
        ], [
            'content'
                => '[content]',
            'title'
                => '[title]',
            'type'
                => '[type]',
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
