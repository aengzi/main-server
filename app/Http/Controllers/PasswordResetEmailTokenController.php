<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\EmailToken\PasswordResetEmailTokenCreatingService;
use Illuminate\Support\Facades\Request;

class PasswordResetEmailTokenController extends Controller
{
    public static function store()
    {
        return [PasswordResetEmailTokenCreatingService::class, [
            'email'
                => static::input('email'),
        ], [
            'email'
                => '[email]',
        ]];
    }
}
