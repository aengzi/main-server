<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\SignIn\SignInCreatingService;

class SignInController extends Controller
{
    public static function store()
    {
        return [SignInCreatingService::class, [
            'email' => static::input('email'),
            'password' => static::input('password'),
        ], [
            'email' => '[email]',
            'password' => '[password]',
        ]];
    }
}
