<?php

namespace App\Services\Clip;

use App\Models\Clip;
use FunctionalCoding\Service;
use FunctionalCoding\Illuminate\Service\FindService;

class ClipFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'clip for {{id}}',
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

                return ['user', 'vod', 'vod.like', 'vod.bcast', 'vod.bcast.bj'];
            },

            'model_class' => function () {

                return Clip::class;
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
