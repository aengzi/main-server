<?php

namespace App\Services\Post;

use App\Models\Post;
use FunctionalCoding\ORM\Eloquent\Service\FindService;
use FunctionalCoding\Service;

class PostFindingService extends Service
{
    public static function getBindNames()
    {
        return [
            'result' => 'post for {{id}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'available_expands' => function () {
                return ['dislike', 'like', 'user'];
            },

            'model_class' => function () {
                return Post::class;
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
