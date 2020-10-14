<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Clip\UserClipCreatingService;
use Illuminate\Support\Facades\Request;

class UserClipController extends Controller
{
    public function store()
    {
        return [UserClipCreatingService::class, [
            'end_sec'
                => $this->input('end_sec'),
            'start_sec'
                => $this->input('start_sec'),
            'title'
                => $this->input('title'),
            'vod_id'
                => $this->input('vod_id'),
        ], [
            'end_sec'
                => '[end_sec]',
            'start_sec'
                => '[start_sec]',
            'title'
                => '[title]',
            'vod_id'
                => '[vod_id]',
        ]];
    }
}
