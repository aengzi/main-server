<?php

namespace App\Services;

use App\Service;
use App\Services\ListingService;

class RandommingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.limit' => ['query', 'limit', function ($query, $limit) {

                $query->take($limit);
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'limit' => [function () {

                return 12;
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'limit'
                => ['integer', 'max:100']
        ];
    }

    public static function getArrTraits()
    {
        return [
            ListingService::class
        ];
    }

}
