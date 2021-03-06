<?php

namespace App\Services\CommentThread;

use App\Models\CommentThread;
use App\Models\User;
use FunctionalCoding\ORM\Eloquent\Service\PaginationListService;
use FunctionalCoding\Service;
use Illuminate\Database\Eloquent\Relations\Relation;

class CommentThreadPagingService extends Service
{
    public static function getBindNames()
    {
        return [
            'related' => 'model for {{related_type}} and {{related_id}}',

            'user' => 'user for {{user_id}}',
        ];
    }

    public static function getCallbacks()
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

    public static function getLoaders()
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

    public static function getPromiseLists()
    {
        return [
            'expands' => ['auth_user:strict'],
        ];
    }

    public static function getRuleLists()
    {
        return [
            'related' => ['not_null'],

            'related_id' => ['integer'],

            'related_type' => ['required_with:{{related_id}}', 'string', 'in:post,vod,ytb_video'],

            'user' => ['not_null'],

            'user_id' => ['integer'],
        ];
    }

    public static function getTraits()
    {
        return [
            PaginationListService::class,
        ];
    }
}
