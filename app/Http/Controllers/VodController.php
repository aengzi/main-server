<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Vod\VodFindingService;
use Illuminate\Support\Facades\Request;

class VodController extends Controller
{
    public function show()
    {
        return [VodFindingService::class, [
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
