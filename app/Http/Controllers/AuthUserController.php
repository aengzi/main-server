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
        return [AuthUserFindingService::class, [
            'fields'
                => $this->input('fields'),
            'expands'
                => $this->input('expands'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : ''
        ], [
            'fields'
                => '[fields]',
            'expands'
                => '[expands]',
            'token'
                => 'header[authorization]'
        ]];
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
            'token'
                => $this->input('token') ? $this->input('token') : (Request::bearerToken() ? Request::bearerToken() : '')
        ], [
            'nick'
                => '[nick]',
            'email'
                => '[email]',
            'password'
                => '[password]',
            'thumbnail'
                => '[thumbnail]',
            'token'
                => $this->input('token') ? '[token]' : 'header[authorization]',
        ]];
    }
}
