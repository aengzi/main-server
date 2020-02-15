<?php

namespace App\Services\Clip;

use App\Service;
use App\Models\Clip;
use App\Models\Vod;
use App\Services\Clip\ClipCreatingService;
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
            'clip_vod' => ['m3u8_string', 'files', 'duration', 'vod', function ($m3u8String, $files, $duration, $vod) {

                $item = new Vod;
                $item->setKeyType('string');
                $item->setIncrementing(false);
                $item->setCast('id', 'string');
                $item->forceFill([
                    'id'           => Str::random(25),
                    'related_type' => 'temp',
                    'review_id'    => $vod->review_id,
                    'started_at'   => $files->first()->started_at,
                    'ended_at'     => $files->last()->ended_at,
                    'data'         => $m3u8String,
                    'duration'     => $duration
                ]);

                return $item;
            }],

            'result' => [function () {

                return new Clip([
                    'created_at' => (new \DateTime)->format('Y-m-d H:i:s')
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
        return [];
    }

    public static function getArrTraits()
    {
        return [
            ClipCreatingService::class
        ];
    }
}
