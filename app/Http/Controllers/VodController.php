<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Vod\VodFindingService;
use Illuminate\Support\Facades\Request;

class VodController extends Controller
{
    public static function show()
    {
        return [VodFindingService::class];
    }
}
