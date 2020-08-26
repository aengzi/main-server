<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\EmailVerification\AuthUserEmailVerificationCreatingService;
use Illuminate\Support\Facades\Request;

class AuthUserEmailVerificationController extends Controller
{
    public function store()
    {
        return [AuthUserEmailVerificationCreatingService::class, [
            'email'
                => $this->input('email'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'email'
                => '[email]',
            'token'
                => 'header[authorization]'
        ]];
    }
}
