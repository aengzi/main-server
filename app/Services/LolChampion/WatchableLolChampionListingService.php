<?php

namespace App\Services\LolChampion;

use App\Models\LolChampion;
use App\Models\LolGame;
use App\Models\LolMeta;
use App\Services\LolChampion\LolChampionListingService;
use FunctionalCoding\Service;

class WatchableLolChampionListingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query' => function ($query) {

                $subQuery1 = LolGame::select('id')
                    ->whereNotNull('vod_id')
                    ->getQuery();
                $subQuery2 = LolMeta::select('value')
                    ->whereIn('game_id', $subQuery1)
                    ->where('property', 'status_champion_id')
                    ->getQuery();
                $query->whereIn('id', $subQuery2);
                $query->orderBy('name', 'asc');
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'model_class' => function () {

                return LolChampion::class;
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
            LolChampionListingService::class,
        ];
    }
}
