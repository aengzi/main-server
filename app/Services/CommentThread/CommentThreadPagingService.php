<?php

namespace App\Services\CommentThread;

use App\Models\CommentThread;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use FunctionalCoding\Service;
use Illuminate\Extend\Service\Database\PaginationListService;

class CommentThreadPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'related'
                => 'model for {{related_type}} and {{related_id}}',

            'user'
                => 'user for {{user_id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.related' => function ($query, $related, $relatedType) {

                $query->where('related_id', $related->getKey());
                $query->where('related_type', $relatedType);
            },

            'query.user' => function ($query, $user) {

                $query->where('user_id', $user->getKey());
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => function () {

                return ['dislike', 'like', 'related', 'user'];
            },

            'cursor' => function ($cursorId, $modelClass) {

                return $modelClass::find($cursorId);
            },

            'model_class' => function () {

                return CommentThread::class;
            },

            'related' => function ($relatedId, $relatedType) {

                return Relation::morphMap()[$relatedType]::find($relatedId);
            },

            'user' => function ($userId) {

                return User::find($userId);
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'expands'
                => ['auth_user:strict'],
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
            PaginationListService::class,
        ];
    }
}
