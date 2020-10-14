<?php

namespace App\Services\Notification;

use App\Service;
use App\Models\Notification;
use App\Services\PagingService;

class NotificationPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.after' => ['after', 'query', function ($after, $query) {

                $query->where('created_at', '>=', $after);
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return [];
            }],

            'model_class' => [function () {

                return Notification::class;
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'after'
                => ['date_format:Y-m-d H:i:s'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            PagingService::class
        ];
    }
}
