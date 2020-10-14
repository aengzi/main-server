<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Auth\AuthUserFindingService;
use App\Services\Auth\AuthUserUpdatingService;
use Illuminate\Support\Facades\Request;

class AuthUserController extends Controller
{
    public function index()
    {
        return [AuthUserFindingService::class];
    }

    public function update()
    {
        return [AuthUserUpdatingService::class, [
            'nick'
                => $this->input('nick'),
            'email'
                => $this->input('email'),
            'password'
                => $this->input('password'),
            'thumbnail'
                => $this->input('thumbnail'),
        ], [
            'nick'
                => '[nick]',
            'email'
                => '[email]',
            'password'
                => '[password]',
            'thumbnail'
                => '[thumbnail]',
        ]];
    }
}
