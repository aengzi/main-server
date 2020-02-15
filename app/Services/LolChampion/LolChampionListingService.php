<?php

namespace App\Services\LolChampion;

use App\Models\LolChampion;
use App\Service;
use App\Services\ListingService;

class LolChampionListingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query' => ['query', function ($query) {

                $query->orderBy('name', 'asc');
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'model_class' => [function () {

                return LolChampion::class;
            }]
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
            ListingService::class
        ];
    }
}
