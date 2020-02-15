<?php

namespace App\Services\Dislike;

use App\Service;
use App\Models\Dislike;
use App\Services\AuthUserRequiringService;

class DislikeDeletingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'dislike'
                => 'dislike for {{dislike_id}}',

            'dislike_user_id'
                => 'user_id of {{dislike}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => ['dislike', function ($dislike) {

                $dislike->delete();

                $count = Dislike::query()
                    ->where('related_id', $dislike->related_id)
                    ->where('related_type', $dislike->related_type)
                    ->count();

                $related = $dislike->related;
                $related->dislike_count = $count;
                $related->save();
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'dislike' => ['dislike_id', function ($dislikeId) {

                return Dislike::find($dislikeId);
            }],

            'dislike_user_id' => ['dislike', function ($dislike) {

                return $dislike->user_id;
            }],

            'result' => [function () {

                return null;
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
            'dislike'
                => ['not_null'],

            'dislike_id'
                => ['required', 'integer'],

            'dislike_user_id'
                => ['same:{{auth_user_id}}']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class
        ];
    }
}
