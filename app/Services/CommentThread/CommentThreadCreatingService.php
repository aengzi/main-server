<?php

namespace App\Services\CommentThread;

use App\Service;
use App\Models\CommentThread;
use App\Services\AuthUserRequiringService;
use Illuminate\Database\Eloquent\Relations\Relation;

class CommentThreadCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'related'
                => 'model for {{related_type}} and {{related_id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result.auth_user' => ['auth_user', 'result', function ($authUser, $result) {

                $result->setRelation('user', $authUser);
            }],

            'result.related' => ['related', 'result', function ($related, $result) {

                $count = CommentThread::query()
                    ->where('related_id', $result->related_id)
                    ->where('related_type', $result->related_type)
                    ->count();

                $related->thread_count = $count;
                $related->save();
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'related' => ['related_id', 'related_type', function ($relatedId, $relatedType) {

                return Relation::morphMap()[$relatedType]::find($relatedId);
            }],

            'result' => ['auth_user', 'message', 'related', 'related_type', function ($authUser, $message, $related, $relatedType) {

                return CommentThread::create([
                    'user_id'
                        => $authUser->getKey(),
                    'message'
                        => $message,
                    'related_id'
                        => $related->getKey(),
                    'related_type'
                        => $relatedType
                ])->fresh();
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
            'related'
                => ['not_null'],

            'related_id'
                => ['required', 'integer'],

            'related_type'
                => ['required', 'string', 'in:post,vod,ytb_video'],

            'message'
                => ['required', 'string']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
