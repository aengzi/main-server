<?php

namespace App\Services\PubgGame;

use App\Models\PubgGame;
use FunctionalCoding\ORM\Eloquent\Service\FindService;
use FunctionalCoding\Service;

class PubgGameFindingService extends Service
{
    public static function getBindNames()
    {
        return [
            'result' => 'pubg_game for {{id}}',
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
                return ['metas', 'vod', 'vod.like', 'vod.bcast', 'vod.bcast.bj', 'timelines'];
            },

            'model_class' => function () {
                return PubgGame::class;
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
