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
            'start_sec'
                => $this->input('start_sec'),
            'end_sec'
                => $this->input('end_sec'),
            'vod_id'
                => $this->input('vod_id')
        ], [
            'start_sec'
                => '[start_sec]',
            'end_sec'
                => '[end_sec]',
            'vod_id'
                => '[vod_id]'
        ]];
    }
}
