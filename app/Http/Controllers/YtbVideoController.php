<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\YtbVideo\YtbVideoFindingService;
use App\Services\YtbVideo\YtbVideoPagingService;
use Illuminate\Support\Facades\Request;

class YtbVideoController extends Controller
{
    public function index()
    {
        return [YtbVideoPagingService::class];
    }

    public function show()
    {
        return [YtbVideoFindingService::class];
    }
}
