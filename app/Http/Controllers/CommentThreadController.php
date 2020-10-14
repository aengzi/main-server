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
        return [CommentThreadDeletingService::class, [
            'id'
                => Request::route('id'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : ''
        ], [
            'id'
                => Request::route('id'),
            'token'
                => 'header[authorization]'
        ]];
    }

    public function index()
    {
        return [CommentThreadPagingService::class, [
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
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : '',
            'user_id'
                => $this->input('user_id'),
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
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'token'
                => 'header[authorization]',
            'user_id'
                => '[user_id]'
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
            'token'
                => Request::bearerToken() ? Request::bearerToken() : ''
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'message'
                => '[message]',
            'token'
                => 'header[authorization]'
        ]];
    }

    public function update()
    {
        return [CommentThreadUpdatingService::class, [
            'id'
                => Request::route('id'),
            'message'
                => $this->input('message'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : ''
        ], [
            'id'
                => Request::route('id'),
            'message'
                => '[message]',
            'token'
                => 'header[authorization]'
        ]];
    }
}
