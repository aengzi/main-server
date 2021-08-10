<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\EmailToken\AuthUserEmailTokenCreatingService;

class AuthUserEmailTokenController extends Controller
{
    public static function store()
    {
        return [AuthUserEmailTokenCreatingService::class, [
            'email' => static::input('email'),
        ], [
            'email' => '[email]',
        ]];
    }
}
