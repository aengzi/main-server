<?php

namespace App\Services\Clip;

use App\Models\Clip;
use App\Models\Vod;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;

class UserClipCreatingService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbackLists()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'clip_vod' => function ($files, $m3u8String, $result, $title, $vod) {
                return Vod::create([
                    'related_type' => 'clip',
                    'related_id' => $result->getKey(),
                    'bcast_id' => $vod->bcast_id,
                    'started_at' => $files->first()->started_at,
                    'ended_at' => $files->last()->ended_at,
                    'data' => $m3u8String,
                    'duration' => $files->sum('duration'),
                    'title' => $title,
                ]);
            },

            'result' => function ($authUser) {
                return Clip::create([
                    'user_id' => $authUser->getKey(),
                ]);
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
            'title' => ['required', 'string', 'max:32'],
        ];
    }

    public static function getTraits()
    {
        return [
            AuthUserRequiringService::class,
            ClipCreatingService::class,
        ];
    }
}
