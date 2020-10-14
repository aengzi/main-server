<?php

namespace App\Services\Like;

use App\Service;
use App\Models\Like;
use App\Services\AuthUserRequiringService;

class LikeDeletingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'like'
                => 'like for {{like_id}}',

            'like_user_id'
                => 'user_id of {{like}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => ['like', function ($like) {

                $like->delete();

                $count = Like::query()
                    ->where('related_id', $like->related_id)
                    ->where('related_type', $like->related_type)
                    ->count();

                $related = $like->related;
                $related->like_count = $count;
                $related->save();
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'like' => ['like_id', function ($likeId) {

                return Like::find($likeId);
            }],

            'like_user_id' => ['like', function ($like) {

                return $like->user_id;
            }],

            'result' => [function () {

                return null;
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
            'like'
                => ['not_null'],

            'like_id'
                => ['required', 'integer'],

            'like_user_id'
                => ['same:{{auth_user_id}}']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
