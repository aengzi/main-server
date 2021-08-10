<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Vod\VodFindingService;

class VodController extends Controller
{
    public static function show()
    {
        return [VodFindingService::class];
    }
}
