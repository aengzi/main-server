<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\LolChampion\LolChampionListingService;

class LolChampionController extends Controller
{
    public function index()
    {
        return [LolChampionListingService::class, [
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
