<?php

namespace App\Services\YtbVideo;

use App\Models\YtbVideo;
use FunctionalCoding\ORM\Eloquent\Service\FindService;
use FunctionalCoding\Service;

class YtbVideoFindingService extends Service
{
    public static function getBindNames()
    {
        return [
            'result' => 'youtube_video for {{id}}',
        ];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'available_expands' => function () {
                return ['like'];
            },

            'model_class' => function () {
                return YtbVideo::class;
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [];
    }

    public static function getTraits()
    {
        return [
            FindService::class,
        ];
    }
}
