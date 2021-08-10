<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\PubgGame\PubgGameFindingService;
use App\Services\PubgGame\PubgGamePagingService;

class PubgGameController extends Controller
{
    public static function index()
    {
        return [PubgGamePagingService::class, [
            'map_names' => static::input('map_names'),
            'queue_sizes' => static::input('queue_sizes'),
        ], [
            'map_names' => '[map_names]',
            'queue_sizes' => '[queue_sizes]',
        ]];
    }

    public static function show()
    {
        return [PubgGameFindingService::class];
    }
}
