<?php

namespace App\Services\Device;

use App\Service;
use App\Models\Device;

class DeviceUpdatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'device'
                => 'device for {{id}}',

            'device_related_id'
                => 'related_id of {{device}}',

            'device_related_type'
                => 'related_type of {{device}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'device' => ['device', function ($device) {

                $device->touch();
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'device' => ['id', function ($id) {

                return Device::find($id);
            }],

            'device_related_id' => ['device', function ($device) {

                return $device->related_id;
            }],

            'device_related_type' => ['device', function ($device) {

                return $device->related_type;
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
                => ['required', 'string', 'same:{{device_related_id}}'],

            'related_type'
                => ['required', 'string', 'same:{{device_related_type}}'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
