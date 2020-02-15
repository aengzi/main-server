<?php

namespace App\Services\Post;

use App\Service;
use App\Models\Post;
use App\Services\FindingService;

class PostFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'post for {{id}}'
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

                return Post::class;
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
