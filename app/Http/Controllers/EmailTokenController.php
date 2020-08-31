<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\EmailToken\EmailTokenUpdatingService;

class EmailTokenController extends Controller
{
    public function update()
    {
        return [EmailTokenUpdatingService::class, [
            'code'
                => $this->input('code'),
            'token'
                => $this->input('token'),
        ], [
            'code'
                => '[code]',
            'token'
                => '[token]',
        ]];
    }
}
