<?php

namespace App\Services\Device;

use App\Models\Device;
use FunctionalCoding\Service;

class DeviceCreatingService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'device' => function ($device) {
                $device->save();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'device' => function ($relatedId, $relatedType) {
                $device = Device::query()
                    ->lockForUpdate()
                    ->where('related_id', $relatedId)
                    ->where('related_type', $relatedType)
                    ->first()
                ;

                if (empty($device)) {
                    $device = Device::create([
                        'related_id' => $relatedId,
                        'related_type' => $relatedType,
                    ]);
                }

                return $device;
            },

            'result' => function ($device) {
                return $device;
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
            'related_id' => ['required', 'string'],

            'related_type' => ['required', 'string', 'in:chrome'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
