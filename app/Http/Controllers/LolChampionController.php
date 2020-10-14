<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\LolChampion\LolChampionListingService;

class LolChampionController extends Controller
{
    public function index()
    {
        return [LolChampionListingService::class];
    }
}
