<?php

namespace App\Services\Notification;

use App\Models\Notification;
use FunctionalCoding\Illuminate\Service\PaginationListService;
use FunctionalCoding\Service;

class NotificationPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.after' => function ($after, $query) {
                $query->where('created_at', '>=', $after);
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => function () {
                return [];
            },

            'cursor' => function ($cursorId, $modelClass) {
                return $modelClass::find($cursorId);
            },

            'model_class' => function () {
                return Notification::class;
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'after' => ['date_format:Y-m-d H:i:s'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            PaginationListService::class,
        ];
    }
}
