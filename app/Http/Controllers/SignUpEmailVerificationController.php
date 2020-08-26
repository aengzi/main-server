<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\EmailVerification\SignUpEmailVerificationCreatingService;
use Illuminate\Support\Facades\Request;

class SignUpEmailVerificationController extends Controller
{
    public function store()
    {
        return [SignUpEmailVerificationCreatingService::class, [
            'email'
                => $this->input('email'),
            'password'
                => $this->input('password'),
            'nick'
                => $this->input('nick')
        ], [
            'email'
                => '[email]',
            'password'
                => '[password]',
            'nick'
                => '[nick]'
        ]];
    }
}
