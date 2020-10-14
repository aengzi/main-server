<?php

namespace App\Services\YtbVideo;

use App\Service;
use App\Models\YtbVideo;
use App\Services\FindingService;

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
            FindingService::class,
        ];
    }
}
