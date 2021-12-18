<?php

namespace App\Services\Dislike;

use App\Models\Dislike;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;

class DislikeDeletingService extends Service
{
    public static function getBindNames()
    {
        return [
            'dislike' => 'dislike for {{dislike_id}}',

            'dislike_user_id' => 'user_id of {{dislike}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'result' => function ($dislike) {
                $dislike->delete();

                $count = Dislike::query()
                    ->where('related_id', $dislike->related_id)
                    ->where('related_type', $dislike->related_type)
                    ->count()
                ;

                $related = $dislike->related;
                $related->dislike_count = $count;
                $related->save();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'dislike' => function ($dislikeId) {
                return Dislike::find($dislikeId);
            },

            'dislike_user_id' => function ($dislike) {
                return $dislike->user_id;
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
            'dislike' => ['not_null'],

            'dislike_id' => ['required', 'integer'],

            'dislike_user_id' => ['same:{{auth_user_id}}'],
        ];
    }

    public static function getTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
