<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\PwdReset\PwdResetCreatingService;
use App\Services\PwdReset\PwdResetUpdatingService;
use Illuminate\Support\Facades\Request;

class PwdResetController extends Controller {

    public function store()
    {
        return [PwdResetCreatingService::class, [
            'email'
                => $this->input('email')
        ], [
            'email'
                => '[email]',
        ]];
    }

    public function update()
    {
        return [PwdResetUpdatingService::class, [
            'id'
                => Request::route('id'),
            'token'
                => $this->input('token'),
            'password'
                => $this->input('password')
        ], [
            'id'
                => Request::route('id'),
            'token'
                => '[token]',
            'password'
                => '[password]'
        ]];
    }

}
