<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\User\UserFindingService;
use App\Services\User\UserListingService;
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
                => Request::bearerToken() ? Request::bearerToken() : ''
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
