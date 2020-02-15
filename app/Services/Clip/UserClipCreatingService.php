<?php

namespace App\Services\Clip;

use App\Service;
use App\Models\Clip;
use App\Models\Vod;
use App\Services\AuthUserRequiringService;
use App\Services\Clip\ClipCreatingService;

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
            'clip_vod' => ['result', 'm3u8_string', 'files', 'duration', 'vod', 'title', function ($result, $m3u8String, $files, $duration, $vod, $title) {

                return Vod::create([
                    'related_type' => 'clip',
                    'related_id'   => $result->getKey(),
                    'review_id'    => $vod->review_id,
                    'started_at'   => $files->first()->started_at,
                    'ended_at'     => $files->last()->ended_at,
                    'data'         => $m3u8String,
                    'duration'     => $duration,
                    'title'        => $title
                ]);
            }],

            'result' => ['auth_user', function ($authUser) {

                return Clip::create([
                    'user_id' => $authUser->getKey()
                ]);
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
            'title'
                => ['required', 'string', 'max:32']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class,
            ClipCreatingService::class
        ];
    }
}
