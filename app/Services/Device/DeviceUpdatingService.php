<?php

namespace App\Services\Device;

use App\Models\Device;
use FunctionalCoding\Service;

class DeviceUpdatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'device' => 'device for {{id}}',

            'device_related_id' => 'related_id of {{device}}',

            'device_related_type' => 'related_type of {{device}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'device' => function ($device) {
                $device->touch();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'device' => function ($id) {
                return Device::find($id);
            },

            'device_related_id' => function ($device) {
                return $device->related_id;
            },

            'device_related_type' => function ($device) {
                return $device->related_type;
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
            'related_id' => ['required', 'string', 'same:{{device_related_id}}'],

            'related_type' => ['required', 'string', 'same:{{device_related_type}}'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
