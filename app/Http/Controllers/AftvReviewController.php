<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\AftvReview\AftvReviewFindingService;
use Illuminate\Support\Facades\Request;

class AftvReviewController extends Controller
{
    public static function show()
    {
        return [AftvReviewFindingService::class];
    }
}
