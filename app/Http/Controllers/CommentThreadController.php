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
    public function destroy()
    {
        return [CommentThreadDeletingService::class];
    }

    public function index()
    {
        return [CommentThreadPagingService::class, [
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
            'user_id'
                => $this->input('user_id'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'user_id'
                => '[user_id]',
        ]];
    }

    public function store()
    {
        return [CommentThreadCreatingService::class, [
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
            'message'
                => $this->input('message'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'message'
                => '[message]',
        ]];
    }

    public function update()
    {
        return [CommentThreadUpdatingService::class, [
            'message'
                => $this->input('message'),
        ], [
            'message'
                => '[message]',
        ]];
    }
}
