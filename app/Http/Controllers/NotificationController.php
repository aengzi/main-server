<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Notification\NotificationPagingService;
use Illuminate\Support\Facades\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return [NotificationPagingService::class, [
            'after'
                => $this->input('after'),
        ], [
            'after'
                => '[after]',
        ]];
    }
}
