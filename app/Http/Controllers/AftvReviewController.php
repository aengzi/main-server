<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\AftvReview\AftvReviewFindingService;

class AftvReviewController extends Controller
{
    public static function show()
    {
        return [AftvReviewFindingService::class];
    }
}
