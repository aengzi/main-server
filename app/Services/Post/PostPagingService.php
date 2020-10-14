<?php

namespace App\Services\Post;

use App\Service;
use App\Models\Post;
use App\Models\User;
use App\Services\PagingService;

class PostPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'user'
                => 'user for {{user_id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.content' => ['query', function ($query) {

                // deleted post's content is null
                $query->whereNotNull('content');
            }],

            'query.type' => ['query', 'type', function ($query, $type) {

                $query->where('type', $type);
            }],

            'query.user' => ['query', 'user', function ($query, $user) {

                $query->where('user_id', $user->getKey());
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return ['dislike', 'like', 'user'];
            }],

            'available_order_by' => [function () {

                return [
                    'created_at desc',
                    'like_count desc'
                ];
            }],

            'model_class' => [function () {

                return Post::class;
            }],

            'user' => ['user_id', function ($userId) {

                return User::find($userId);
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'user'
                => ['not_null'],

            'user_id'
                => ['integer'],

            'type'
                => ['string']
        ];
    }

    public static function getArrTraits()
    {
        return [
            PagingService::class
        ];
    }
}
