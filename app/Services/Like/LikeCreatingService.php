<?php

namespace App\Services\Like;

use App\Models\Like;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;
use Illuminate\Database\Eloquent\Relations\Relation;

class LikeCreatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'like' => 'like for {{related}}',

            'related' => 'related for {{related_id}} and {{related_type}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'result' => function ($result) {
                $count = Like::query()
                    ->where('related_id', $result->related_id)
                    ->where('related_type', $result->related_type)
                    ->count()
                ;

                $related = $result->related;
                $related->like_count = $count;
                $related->save();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'like' => function ($authUser, $related) {
                return Like::query()
                    ->where('user_id', $authUser->getKey())
                    ->where('related_id', $related->getKey())
                    ->first()
                ;
            },

            'related' => function ($relatedId, $relatedType) {
                return Relation::morphMap()[$relatedType]::find($relatedId);
            },

            'result' => function ($authUser, $related, $relatedType) {
                return Like::create([
                    'user_id' => $authUser->getKey(),
                    'related_id' => $related->getKey(),
                    'related_type' => $relatedType,
                ]);
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [
            'result' => ['like'],
        ];
    }

    public static function getRuleLists()
    {
        return [
            'like' => ['null'],

            'related' => ['not_null'],

            'related_id' => ['required', 'integer'],

            'related_type' => ['required', 'string', 'in:comment_thread,post,vod,ytb_video'],
        ];
    }

    public static function getTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
