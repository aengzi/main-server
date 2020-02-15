<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\PubgGame\PubgGameFindingService;
use App\Services\PubgGame\PubgGamePagingService;
use Illuminate\Support\Facades\Request;

class PubgGameController extends Controller
{
    public function index()
    {
        return [PubgGamePagingService::class, [
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'limit'
                => $this->input('limit'),
            'map_names'
                => $this->input('map_names'),
            'order_by'
                => $this->input('order_by'),
            'page'
                => $this->input('page'),
            'queue_sizes'
                => $this->input('queue_sizes'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'limit'
                => '[limit]',
            'map_names'
                => '[map_names]',
            'order_by'
                => '[order_by]',
            'page'
                => '[page]',
            'queue_sizes'
                => '[queue_sizes]',
            'token'
                => 'header[authorization]'
        ]];
    }

    public function show()
    {
        return [PubgGameFindingService::class, [
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
                => 'expands',
            'fields'
                => 'fields',
            'id'
                => Request::route('id'),
            'token'
                => 'header[authorization]'
        ]];
    }
}
