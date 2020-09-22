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
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'group_by'
                => $this->input('group_by'),
            'limit'
                => $this->input('limit'),
            'order_by'
                => $this->input('order_by'),
            'page'
                => $this->input('page'),
        ], [
            'after'
                => '[after]',
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'group_by'
                => '[group_by]',
            'limit'
                => '[limit]',
            'order_by'
                => '[order_by]',
            'page'
                => '[page]',
        ]];
    }
}
