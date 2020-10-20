<?php

namespace App\Services\YtbVideo;

use App\Models\YtbVideo;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Database\PaginationListService;

class YtbVideoPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return ['like'];
            }],

            'cursor' => ['cursor_id', 'model_class', function ($cursorId, $modelClass) {

                return $modelClass::find($cursorId);
            }],

            'model_class' => [function () {

                return YtbVideo::class;
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [];
    }

    public static function getArrTraits()
    {
        return [
            PaginationListService::class,
        ];
    }
}
