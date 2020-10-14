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
            'map_names'
                => $this->input('map_names'),
            'queue_sizes'
                => $this->input('queue_sizes'),
        ], [
            'map_names'
                => '[map_names]',
            'queue_sizes'
                => '[queue_sizes]',
        ]];
    }

    public function show()
    {
        return [PubgGameFindingService::class];
    }
}
