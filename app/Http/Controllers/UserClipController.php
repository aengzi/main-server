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
            'ended_at'
                => $this->input('ended_at'),
            'started_at'
                => $this->input('started_at'),
            'title'
                => $this->input('title'),
            'vod_id'
                => $this->input('vod_id'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'ended_at'
                => '[ended_at]',
            'started_at'
                => '[started_at]',
            'title'
                => '[title]',
            'vod_id'
                => '[vod_id]',
            'token'
                => 'header[authorization]'
        ]];
    }
}
