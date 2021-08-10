<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\EmailToken\EmailTokenUpdatingService;

class EmailTokenController extends Controller
{
    public static function update()
    {
        return [EmailTokenUpdatingService::class, [
            'code' => static::input('code'),
        ], [
            'code' => '[code]',
        ]];
    }
}
