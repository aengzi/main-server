<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\AftvBcast\AftvBcastFindingService;
use App\Services\AftvBcast\AftvBcastPagingService;
use Illuminate\Support\Facades\Request;

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
