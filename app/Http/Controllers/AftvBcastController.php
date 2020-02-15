<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\AftvBcast\AftvBcastFindingService;
use App\Services\AftvBcast\AftvBcastPagingService;
use Illuminate\Support\Facades\Request;

class AftvBcastController extends Controller
{
    public function index()
    {
        return [AftvBcastPagingService::class, [
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
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
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
            'token'
                => 'header[authorization]'
        ]];
    }

    public function show()
    {
        return [AftvBcastFindingService::class, [
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
