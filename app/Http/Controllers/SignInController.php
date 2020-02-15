<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\SignIn\SignInCreatingService;
use Illuminate\Support\Facades\Request;

class SignInController extends Controller
{
    public function store()
    {
        return [SignInCreatingService::class, [
            'email'
                => $this->input('email'),
            'password'
                => $this->input('password')
        ], [
            'email'
                => '[email]',
            'password'
                => '[password]'
        ]];
    }
}
