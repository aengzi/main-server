<?php

namespace App\Services\CommentThread;

use App\Service;
use App\Models\CommentThread;
use App\Models\User;
use App\Services\PagingService;
use Illuminate\Database\Eloquent\Relations\Relation;

class CommentThreadPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'user'
                => 'user for {{user_id}}',

            'related'
                => 'model for {{related_type}} and {{related_id}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.user' => ['query', 'user', function ($query, $user) {

                $query->where('user_id', $user->getKey());
            }],

            'query.related' => ['query', 'related', 'related_type', function ($query, $related, $relatedType) {

                $query->where('related_id', $related->getKey());
                $query->where('related_type', $relatedType);
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return ['dislike', 'like', 'related', 'user'];
            }],

            'model_class' => [function () {

                return CommentThread::class;
            }],

            'user' => ['user_id', function ($userId) {

                return User::find($userId);
            }],

            'related' => ['related_id', 'related_type', function ($relatedId, $relatedType) {

                return Relation::morphMap()[$relatedType]::find($relatedId);
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'expands'
                => ['auth_user:strict']
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'related'
                => ['not_null'],

            'related_id'
                => ['integer'],

            'related_type'
                => ['required_with:{{related_id}}', 'string', 'in:post,vod,ytb_video'],

            'user'
                => ['not_null'],

            'user_id'
                => ['integer']
        ];
    }

    public static function getArrTraits()
    {
        return [
            PagingService::class
        ];
    }
}
