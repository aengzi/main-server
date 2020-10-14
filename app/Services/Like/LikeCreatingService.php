<?php

namespace App\Services\Like;

use App\Models\CommentThread;
use App\Models\Like;
use App\Models\Post;
use App\Models\Vod;
use App\Models\YtbVideo;
use App\Services\Auth\AuthUserRequiringService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Extend\Service;

class LikeCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'like'
                => 'like for {{related}}',

            'related'
                => 'related for {{related_id}} and {{related_type}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => ['result', function ($result) {

                $count = Like::query()
                    ->where('related_id', $result->related_id)
                    ->where('related_type', $result->related_type)
                    ->count();

                $related = $result->related;
                $related->like_count = $count;
                $related->save();
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'like' => ['auth_user', 'related', function ($authUser, $related) {

                return Like::query()
                    ->where('user_id', $authUser->getKey())
                    ->where('related_id', $related->getKey())
                    ->first();
            }],

            'related' => ['related_id', 'related_type', function ($relatedId, $relatedType) {

                return Relation::morphMap()[$relatedType]::find($relatedId);
            }],

            'result' => ['auth_user', 'related', 'related_type', function ($authUser, $related, $relatedType) {

                return Like::create([
                    'user_id'
                        => $authUser->getKey(),
                    'related_id'
                        => $related->getKey(),
                    'related_type'
                        => $relatedType
                ]);
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'result'
                => ['like'],
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'like'
                => ['null'],

            'related'
                => ['not_null'],

            'related_id'
                => ['required', 'integer'],

            'related_type'
                => ['required', 'string', 'in:comment_thread,post,vod,ytb_video']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
