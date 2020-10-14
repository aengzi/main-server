<?php

namespace App\Services\YtbVideo;

use App\Models\YtbVideo;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Query\FindService;

class YtbVideoFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'youtube_video for {{id}}',
        ];
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
            FindService::class,
        ];
    }
}
