<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Email\EmailCreatingService;

class EmailController extends Controller
{
    public static function store()
    {
        return [EmailCreatingService::class, [
            'body' => static::input('body'),
            'email' => static::input('email'),
            'subject' => static::input('subject'),
        ], [
            'body' => '[body]',
            'email' => '[email]',
            'subject' => '[subject]',
        ]];
    }
}
