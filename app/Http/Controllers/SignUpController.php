<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\SignUp\SignUpCreatingService;
use Illuminate\Support\Facades\Request;

class SignUpController extends Controller
{
    public function store()
    {
        return [SignUpCreatingService::class];
    }
}
