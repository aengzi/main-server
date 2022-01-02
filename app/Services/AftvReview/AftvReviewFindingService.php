<?php

namespace App\Services\AftvReview;

use App\Models\AftvReview;
use FunctionalCoding\ORM\Eloquent\Service\FindService;
use FunctionalCoding\Service;

class AftvReviewFindingService extends Service
{
    public static function getBindNames()
    {
        return [
            'result' => 'aftv_review for {{id}}',
        ];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
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
