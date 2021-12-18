<?php

namespace App\Services\AftvBcast;

use App\Models\AftvBcast;
use FunctionalCoding\ORM\Eloquent\Service\FindService;
use FunctionalCoding\Service;

class AftvBcastFindingService extends Service
{
    public static function getBindNames()
    {
        return [
            'result' => 'aftv_bcast for {{id}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'available_expands' => function () {
                return ['bj', 'm3u8s', 'vod', 'vod.like'];
            },

            'model_class' => function () {
                return AftvBcast::class;
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
