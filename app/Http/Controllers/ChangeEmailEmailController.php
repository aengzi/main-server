<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Email\ChangeEmailEmailCreatingService;
use Illuminate\Support\Facades\Request;

class ChangeEmailEmailController extends Controller
{
    public function store()
    {
        return [ChangeEmailEmailCreatingService::class, [
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
