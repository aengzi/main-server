<?php

namespace App\Services\Device;

use App\Service;
use App\Models\Device;

class DeviceCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'device' => ['device', function ($device) {

                $device->save();
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'device' => ['related_id', 'related_type', function ($relatedId, $relatedType) {

                $device = Device::query()
                    ->lockForUpdate()
                    ->where('related_id', $relatedId)
                    ->where('related_type', $relatedType)
                    ->first();

                if ( empty($device) )
                {
                    $device = Device::create([
                        'related_id'
                            => $relatedId,
                        'related_type'
                            => $relatedType,
                    ]);
                }

                return $device;
            }],

            'result' => ['device', function ($device) {

                return $device;
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'related_id'
                => ['required', 'string'],

            'related_type'
                => ['required', 'string', 'in:chrome'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
