<?php

namespace App\Services\Like;

use App\Models\Like;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;

class LikeDeletingService extends Service
{
    public static function getBindNames()
    {
        return [
            'like' => 'like for {{like_id}}',

            'like_user_id' => 'user_id of {{like}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'result' => function ($like) {
                $like->delete();

                $count = Like::query()
                    ->where('related_id', $like->related_id)
                    ->where('related_type', $like->related_type)
                    ->count()
                ;

                $related = $like->related;
                $related->like_count = $count;
                $related->save();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'like' => function ($likeId) {
                return Like::find($likeId);
            },

            'like_user_id' => function ($like) {
                return $like->user_id;
            },

            'result' => function () {
                return null;
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'like' => ['not_null'],

            'like_id' => ['required', 'integer'],

            'like_user_id' => ['same:{{auth_user_id}}'],
        ];
    }

    public static function getTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
