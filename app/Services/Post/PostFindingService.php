<?php

namespace App\Services\Post;

use App\Models\Post;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Database\FindService;

class PostFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'post for {{id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return ['dislike', 'like', 'user'];
            }],

            'model_class' => [function () {

                return Post::class;
            }],
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
