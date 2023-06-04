<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Auth\AuthUserFindingService;
use App\Services\Auth\AuthUserUpdatingService;

class AuthUserController extends Controller
{
    public static function index()
    {
        return static::bearerToken() ? [AuthUserFindingService::class] : [Service::class, ['result' => null]];
    }

    public static function update()
    {
        return [AuthUserUpdatingService::class, [
            'nick' => static::input('nick'),
            'email' => static::input('email'),
            'password' => static::input('password'),
            'thumbnail' => static::input('thumbnail'),
        ], [
            'nick' => '[nick]',
            'email' => '[email]',
            'password' => '[password]',
            'thumbnail' => '[thumbnail]',
        ]];
    }
}
