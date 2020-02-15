<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Email\SignUpEmailCreatingService;
use Illuminate\Support\Facades\Request;

class SignUpEmailController extends Controller
{
    public function store()
    {
        return [SignUpEmailCreatingService::class, [
            'email'
                => $this->input('email'),
            'password'
                => $this->input('password'),
            'nick'
                => $this->input('nick')
        ], [
            'email'
                => '[email]',
            'password'
                => '[password]',
            'nick'
                => '[nick]'
        ]];
    }
}
