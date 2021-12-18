<?php

namespace App\Services\Dislike;

use App\Models\Dislike;
use App\Models\User;
use FunctionalCoding\ORM\Eloquent\Service\PaginationListService;
use FunctionalCoding\Service;
use Illuminate\Database\Eloquent\Relations\Relation;

class DislikePagingService extends Service
{
    public static function getBindNames()
    {
        return [
            'available_related_types' => 'available options for {{related_types}}',

            'related' => 'related for {{related_id}} and {{related_type}}',

            'user' => 'user for {{user_id}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'query.related' => function ($query, $related, $relatedType) {
                $query->where('related_id', $related->getKey());
                $query->where('related_type', $relatedType);
            },

            'query.related_types' => function ($query, $relatedTypes) {
                $relatedTypes = preg_split('/\s*,\s*/', $relatedTypes);
                $query->whereIn('related_type', $relatedTypes);
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
                return ['user', 'vod', 'related'];
            },

            'available_related_types' => function () {
                return ['comment_thread', 'post'];
            },

            'cursor' => function ($cursorId, $modelClass) {
                return $modelClass::find($cursorId);
            },

            'model_class' => function () {
                return Dislike::class;
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
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'related' => ['not_null'],

            'related_id' => ['integer'],

            'related_type' => ['required_with:{{related_id}}', 'string', 'in_array:{{available_related_types}}.*'],

            'related_types' => ['string', 'several_in:{{available_related_types}}'],

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
