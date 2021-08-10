<?php

namespace App\Services\LolGame;

use App\Models\LolGame;
use FunctionalCoding\Illuminate\Service\FindService;
use FunctionalCoding\Service;

class LolGameFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result' => 'lol_game for {{id}}',
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
                return LolGame::class;
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
