<?php

namespace App\Services\AftvBcast;

use App\Models\AftvBcast;
use FunctionalCoding\ORM\Eloquent\Service\FindService;
use FunctionalCoding\Service;

class AftvBcastFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result' => 'aftv_bcast for {{id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
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
