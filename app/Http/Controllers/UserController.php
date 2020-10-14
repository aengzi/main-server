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
        ], [
            'email'
                => '[email]',
            'nick'
                => '[nick]',
        ]];
    }

    public function show()
    {
        return [UserFindingService::class];
    }
}
