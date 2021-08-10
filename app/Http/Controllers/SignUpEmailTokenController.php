<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\EmailToken\SignUpEmailTokenCreatingService;

class SignUpEmailTokenController extends Controller
{
    public static function store()
    {
        return [SignUpEmailTokenCreatingService::class, [
            'email' => static::input('email'),
            'password' => static::input('password'),
            'nick' => static::input('nick'),
        ], [
            'email' => '[email]',
            'password' => '[password]',
            'nick' => '[nick]',
        ]];
    }
}
