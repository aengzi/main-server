<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\EmailToken\SignUpEmailTokenCreatingService;
use Illuminate\Support\Facades\Request;

class SignUpEmailTokenController extends Controller
{
    public function store()
    {
        return [SignUpEmailTokenCreatingService::class, [
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
