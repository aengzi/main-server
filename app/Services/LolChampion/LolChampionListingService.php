<?php

namespace App\Services\LolChampion;

use App\Models\LolChampion;
use FunctionalCoding\Service;
use Illuminate\Extend\Service\Database\ListService;

class LolChampionListingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query' => function ($query) {

                $query->orderBy('name', 'asc');
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => function () {

                return [];
            },

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
            ListService::class,
        ];
    }
}
