<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Device\DeviceCreatingService;
use App\Services\Device\DeviceUpdatingService;
use Illuminate\Support\Facades\Request;

class DeviceController extends Controller
{
    public function store()
    {
        return [DeviceCreatingService::class, [
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
        ]];
    }

    public function update()
    {
        return [DeviceUpdatingService::class, [
            'id'
                => Request::route('id'),
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
        ], [
            'id'
                => Request::route('id'),
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
        ]];
    }
}
