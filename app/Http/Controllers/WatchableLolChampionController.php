<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\LolChampion\WatchableLolChampionListingService;

class WatchableLolChampionController extends Controller
{
    public function index()
    {
        return [WatchableLolChampionListingService::class, [
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields')
        ], [
            'expands'
                => '[expands]',
            'fields'
                => '[fields]'
        ]];
    }
}
