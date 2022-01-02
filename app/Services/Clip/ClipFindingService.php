<?php

namespace App\Services\Clip;

use App\Models\Clip;
use FunctionalCoding\ORM\Eloquent\Service\FindService;
use FunctionalCoding\Service;

class ClipFindingService extends Service
{
    public static function getBindNames()
    {
        return [
            'result' => 'clip for {{id}}',
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
                return ['user', 'vod', 'vod.like', 'vod.bcast', 'vod.bcast.bj'];
            },

            'model_class' => function () {
                return Clip::class;
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
