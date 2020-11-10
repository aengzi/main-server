<?php

namespace App\Services\Clip;

use App\Models\Clip;
use App\Models\Vod;
use App\Services\Auth\AuthUserRequiringService;
use App\Services\Clip\ClipCreatingService;
use Illuminate\Extend\Service;

class UserClipCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'clip_vod' => function ($files, $m3u8String, $result, $title, $vod) {

                return Vod::create([
                    'related_type' => 'clip',
                    'related_id'   => $result->getKey(),
                    'bcast_id'     => $vod->bcast_id,
                    'started_at'   => $files->first()->started_at,
                    'ended_at'     => $files->last()->ended_at,
                    'data'         => $m3u8String,
                    'duration'     => $files->sum('duration'),
                    'title'        => $title
                ]);
            },

            'result' => function ($authUser) {

                return Clip::create([
                    'user_id' => $authUser->getKey()
                ]);
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'title'
                => ['required', 'string', 'max:32']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class,
            ClipCreatingService::class,
        ];
    }
}
