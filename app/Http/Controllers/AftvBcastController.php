<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\AftvBcast\AftvBcastFindingService;
use App\Services\AftvBcast\AftvBcastPagingService;

class AftvBcastController extends Controller
{
    public static function index()
    {
        return [AftvBcastPagingService::class];
    }

    public static function show()
    {
        return [AftvBcastFindingService::class];
    }
}
