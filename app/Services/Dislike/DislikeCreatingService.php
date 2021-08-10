<?php

namespace App\Services\Dislike;

use App\Models\Dislike;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;
use Illuminate\Database\Eloquent\Relations\Relation;

class DislikeCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'dislike' => 'dislike for {{related}}',

            'related' => 'related for {{related_id}} and {{related_type}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => function ($result) {
                $count = Dislike::query()
                    ->where('related_id', $result->related_id)
                    ->where('related_type', $result->related_type)
                    ->count()
                ;

                $related = $result->related;
                $related->dislike_count = $count;
                $related->save();
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'dislike' => function ($authUser, $related) {
                return Dislike::query()
                    ->where('user_id', $authUser->getKey())
                    ->where('related_id', $related->getKey())
                    ->first()
                ;
            },

            'related' => function ($relatedId, $relatedType) {
                return Relation::morphMap()[$relatedType]::find($relatedId);
            },

            'result' => function ($authUser, $related, $relatedType) {
                return Dislike::create([
                    'user_id' => $authUser->getKey(),
                    'related_id' => $related->getKey(),
                    'related_type' => $relatedType,
                ]);
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'result' => ['dislike'],
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'dislike' => ['null'],

            'related' => ['not_null'],

            'related_id' => ['required', 'integer'],

            'related_type' => ['required', 'string', 'in:comment_thread,post'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
