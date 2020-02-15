<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Clip\ClipFindingService;
use App\Services\Clip\ClipPagingService;
use App\Services\Clip\ClipDeletingService;
use Illuminate\Support\Facades\Request;

class ClipController extends Controller
{
    public function destroy()
    {
        return [ClipDeletingService::class, [
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
        return [ClipPagingService::class, [
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'group_by'
                => $this->input('group_by'),
            'limit'
                => $this->input('limit'),
            'order_by'
                => $this->input('order_by'),
            'page'
                => $this->input('page'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass,
            'user_id'
                => $this->input('user_id'),
            'vod_id'
                => $this->input('vod_id')
        ], [
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'group_by'
                => '[group_by]',
            'limit'
                => '[limit]',
            'order_by'
                => '[order_by]',
            'page'
                => '[page]',
            'token'
                => 'header[authorization]',
            'user_id'
                => '[user_id]',
            'vod_id'
                => '[vod_id]'
        ]];
    }

    public function show()
    {
        return [ClipFindingService::class, [
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
}
