<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\User\UserFindingService;
use App\Services\User\UserListingService;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    public static function index()
    {
        return [UserListingService::class, [
            'email'
                => static::input('email'),
            'nick'
                => static::input('nick'),
        ], [
            'email'
                => '[email]',
            'nick'
                => '[nick]',
        ]];
    }

    public static function show()
    {
        return [UserFindingService::class];
    }
}
