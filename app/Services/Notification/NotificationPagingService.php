<?php

namespace App\Services\Notification;

use App\Models\Notification;
use FunctionalCoding\ORM\Eloquent\Service\PaginationListService;
use FunctionalCoding\Service;

class NotificationPagingService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbackLists()
    {
        return [
            'query.after' => function ($after, $query) {
                $query->where('created_at', '>=', $after);
            },
        ];
    }

    public static function getLoaders()
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

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'after' => ['date_format:Y-m-d H:i:s'],
        ];
    }

    public static function getTraits()
    {
        return [
            PaginationListService::class,
        ];
    }
}
