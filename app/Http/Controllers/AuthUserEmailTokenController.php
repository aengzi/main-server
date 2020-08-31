<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\EmailToken\AuthUserEmailTokenCreatingService;
use Illuminate\Support\Facades\Request;

class AuthUserEmailTokenController extends Controller
{
    public function store()
    {
        return [AuthUserEmailTokenCreatingService::class, [
            'email'
                => $this->input('email'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'email'
                => '[email]',
            'token'
                => 'header[authorization]'
        ]];
    }
}
