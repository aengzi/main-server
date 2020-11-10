<?php

namespace App\Services\PubgGame;

use App\Models\PubgGame;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Database\FindService;

class PubgGameFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'pubg_game for {{id}}',
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

                return ['metas', 'vod', 'vod.like', 'vod.bcast', 'vod.bcast.bj', 'timelines'];
            },

            'model_class' => function () {

                return PubgGame::class;
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
