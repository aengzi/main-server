<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\AftvReview\AftvReviewFindingService;
use Illuminate\Support\Facades\Request;

class AftvReviewController extends Controller
{
    public function show()
    {
        return [AftvReviewFindingService::class];
    }
}
