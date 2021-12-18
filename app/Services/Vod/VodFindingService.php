<?php

namespace App\Services\Vod;

use App\Models\Vod;
use FunctionalCoding\ORM\Eloquent\Service\FindService;
use FunctionalCoding\Service;

class VodFindingService extends Service
{
    public static function getBindNames()
    {
        return [
            'result' => 'vod for {{id}}',
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
                return ['like', 'related', 'bcast'];
            },

            'model_class' => function () {
                return Vod::class;
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
