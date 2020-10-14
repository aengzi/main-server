<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Vod\VodFindingService;
use Illuminate\Support\Facades\Request;

class VodController extends Controller
{
    public function show()
    {
        return [VodFindingService::class];
    }
}
