<?php

namespace App\Services\Clip;

use App\Service;
use App\Models\Clip;
use App\Services\FindingService;

class ClipFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'clip for {{id}}'
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

                return Clip::class;
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
