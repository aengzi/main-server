<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\User\UserFindingService;
use App\Services\User\UserListingService;
use App\Services\User\UserUpdatingService;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    public function index()
    {
        return [UserListingService::class, [
            'email'
                => $this->input('email'),
            'nick'
                => $this->input('nick'),
            'fields'
                => $this->input('fields')
        ], [
            'email'
                => '[email]',
            'nick'
                => '[nick]',
            'fields'
                => '[fields]'
        ]];
    }

    public function update()
    {
        return [UserUpdatingService::class, [
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

    public function show()
    {
        return [UserFindingService::class, [
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'id'
                => Request::route('id'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'id'
                => Request::route('id'),
            'token'
                => 'header[authorization]'
        ]];
    }
}
