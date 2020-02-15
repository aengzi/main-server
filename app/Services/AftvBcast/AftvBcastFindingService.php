<?php

namespace App\Services\AftvBcast;

use App\Service;
use App\Models\AftvBcast;
use App\Services\FindingService;

class AftvBcastFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'aftv_bcast for {{id}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'model_class' => [function () {

                return AftvBcast::class;
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
            FindingService::class
        ];
    }
}
