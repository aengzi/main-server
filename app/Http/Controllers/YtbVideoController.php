<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\YtbVideo\YtbVideoFindingService;
use App\Services\YtbVideo\YtbVideoPagingService;

class YtbVideoController extends Controller
{
    public static function index()
    {
        return [YtbVideoPagingService::class];
    }

    public static function show()
    {
        return [YtbVideoFindingService::class];
    }
}
