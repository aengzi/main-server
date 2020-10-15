<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Device\DeviceCreatingService;
use App\Services\Device\DeviceUpdatingService;
use Illuminate\Support\Facades\Request;

class DeviceController extends Controller
{
    public static function store()
    {
        return [DeviceCreatingService::class, [
            'related_id'
                => static::input('related_id'),
            'related_type'
                => static::input('related_type'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
        ]];
    }

    public static function update()
    {
        return [DeviceUpdatingService::class, [
            'related_id'
                => static::input('related_id'),
            'related_type'
                => static::input('related_type'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
        ]];
    }
}
