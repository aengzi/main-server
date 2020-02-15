<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Clip\TempClipCreatingService;
use Illuminate\Support\Facades\Request;

class TempClipController extends Controller
{
    public function store()
    {
        return [TempClipCreatingService::class, [
            'started_at'
                => $this->input('started_at'),
            'ended_at'
                => $this->input('ended_at'),
            'vod_id'
                => $this->input('vod_id')
        ], [
            'started_at'
                => '[started_at]',
            'ended_at'
                => '[ended_at]',
            'vod_id'
                => '[vod_id]'
        ]];
    }
}
