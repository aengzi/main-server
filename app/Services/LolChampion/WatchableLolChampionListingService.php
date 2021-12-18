<?php

namespace App\Services\LolChampion;

use App\Models\LolChampion;
use App\Models\LolGame;
use App\Models\LolMeta;
use FunctionalCoding\Service;

class WatchableLolChampionListingService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbackLists()
    {
        return [
            'query' => function ($query) {
                $subQuery1 = LolGame::select('id')
                    ->whereNotNull('vod_id')
                    ->getQuery()
                ;
                $subQuery2 = LolMeta::select('value')
                    ->whereIn('game_id', $subQuery1)
                    ->where('property', 'status_champion_id')
                    ->getQuery()
                ;
                $query->whereIn('id', $subQuery2);
                $query->orderBy('name', 'asc');
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'model_class' => function () {
                return LolChampion::class;
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
            LolChampionListingService::class,
        ];
    }
}
