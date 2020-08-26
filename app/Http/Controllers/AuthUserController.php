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
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
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
            'id'
                => Request::route('id'),
            'nick'
                => $this->input('nick'),
            'password'
                => $this->input('password'),
            'thumbnail'
                => $this->input('thumbnail'),
            'token'
                => Request::has('token') ? $this->input('token') : Request::bearerToken()
        ], [
            'id'
                => Request::route('id'),
            'nick'
                => '[nick]',
            'password'
                => '[password]',
            'thumbnail'
                => '[thumbnail]',
            'token'
                => Request::has('token') ? '[token]' : 'header[authorization bearer]'
        ]];
    }
}
