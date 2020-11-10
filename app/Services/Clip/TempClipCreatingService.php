<?php

namespace App\Services\Clip;

use App\Models\Clip;
use App\Models\Vod;
use App\Services\Clip\ClipCreatingService;
use Illuminate\Extend\Service;
use Illuminate\Support\Str;

class TempClipCreatingService extends Service
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
            'clip_vod' => function ($files, $m3u8String, $vod) {

                $item = new Vod;
                $item->setKeyType('string');
                $item->setIncrementing(false);
                $item->setCast('id', 'string');
                $item->forceFill([
                    'id'           => Str::random(25),
                    'related_type' => 'temp',
                    'bcast_id'     => $vod->bcast_id,
                    'started_at'   => $files->first()->started_at,
                    'ended_at'     => $files->last()->ended_at,
                    'data'         => $m3u8String,
                    'duration'     => $files->sum('duration')
                ]);

                return $item;
            },

            'result' => function () {

                return new Clip([
                    'created_at' => (new \DateTime)->format('Y-m-d H:i:s')
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
        return [];
    }

    public static function getArrTraits()
    {
        return [
            ClipCreatingService::class,
        ];
    }
}
