<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\LolChampion\WatchableLolChampionListingService;

class WatchableLolChampionController extends Controller
{
    public function index()
    {
        return [WatchableLolChampionListingService::class];
    }
}
