<?php

namespace App\Services\AftvReview;

use App\Service;
use App\Models\AftvReview;
use App\Services\FindingService;

class AftvReviewFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'aftv_review for {{id}}'
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

                return AftvReview::class;
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
