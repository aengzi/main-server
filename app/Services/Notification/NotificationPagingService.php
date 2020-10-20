<?php

namespace App\Services\Notification;

use App\Models\Notification;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Database\PaginationListService;

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

            'cursor' => ['cursor_id', 'model_class', function ($cursorId, $modelClass) {

                return $modelClass::find($cursorId);
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
            PaginationListService::class,
        ];
    }
}
