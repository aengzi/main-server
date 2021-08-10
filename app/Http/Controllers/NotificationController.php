<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Notification\NotificationPagingService;

class NotificationController extends Controller
{
    public static function index()
    {
        return [NotificationPagingService::class, [
            'after' => static::input('after'),
        ], [
            'after' => '[after]',
        ]];
    }
}
