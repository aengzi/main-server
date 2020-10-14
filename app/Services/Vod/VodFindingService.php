<?php

namespace App\Services\Vod;

use App\Models\Vod;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Query\FindService;

class VodFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'vod for {{id}}',
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

                return ['like', 'related', 'bcast'];
            }],

            'model_class' => [function () {

                return Vod::class;
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
