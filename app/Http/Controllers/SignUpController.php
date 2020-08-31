<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\SignUp\SignUpCreatingService;
use Illuminate\Support\Facades\Request;

class SignUpController extends Controller
{
    public function store()
    {
        return [SignUpCreatingService::class, [
            'token'
                => Request::bearerToken() ? Request::bearerToken() : $this->input('token'),
        ], [
            'token'
                => Request::bearerToken() ? 'header[authorization]' : '[token]'
        ]];
    }
}
