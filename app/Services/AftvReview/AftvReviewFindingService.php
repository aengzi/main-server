<?php

namespace App\Services\AftvReview;

use App\Models\AftvReview;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Database\FindService;

class AftvReviewFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'aftv_review for {{id}}',
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

                return ['bcast', 'bcast.reviews', 'bcast.reviews.vod', 'bj', 'm3u8s', 'vod', 'vod.like'];
            },

            'model_class' => function () {

                return AftvReview::class;
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
