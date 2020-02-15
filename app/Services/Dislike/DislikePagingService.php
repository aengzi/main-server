<?php

namespace App\Services\Dislike;

use App\Service;
use App\Models\CommentThread;
use App\Models\Dislike;
use App\Models\User;
use App\Services\PagingService;
use Illuminate\Database\Eloquent\Relations\Relation;

class DislikePagingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'available_related_types'
                => 'available options for {{related_types}}',

            'related'
                => 'related for {{related_id}} and {{related_type}}',

            'user'
                => 'user for {{user_id}}'
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
            }],

            'query.related_types' => ['query', 'related_types', function ($query, $relatedTypes) {

                $relatedTypes = preg_split('/\s*,\s*/', $relatedTypes);
                $query->whereIn('related_type', $relatedTypes);
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_related_types' => [function () {

                return ['comment_thread', 'post'];
            }],

            'model_class' => [function () {

                return Dislike::class;
            }],

            'related' => ['related_id', 'related_type', function ($relatedId, $relatedType) {

                return Relation::morphMap()[$relatedType]::find($relatedId);
            }],

            'user' => ['user_id', function ($userId) {

                return User::find($userId);
            }]
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
                => ['integer'],

            'related_type'
                => ['required_with:{{related_id}}', 'string', 'in_array:{{available_related_types}}.*'],

            'related_types'
                => ['string', 'several_in:{{available_related_types}}'],

            'user'
                => ['not_null'],

            'user_id'
                => ['integer'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            PagingService::class
        ];
    }
}
