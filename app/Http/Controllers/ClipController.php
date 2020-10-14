<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Clip\ClipFindingService;
use App\Services\Clip\ClipPagingService;
use App\Services\Clip\ClipDeletingService;
use Illuminate\Support\Facades\Request;

class ClipController extends Controller
{
    public function destroy()
    {
        return [ClipDeletingService::class];
    }

    public function index()
    {
        return [ClipPagingService::class, [
            'user_id'
                => $this->input('user_id'),
            'vod_id'
                => $this->input('vod_id'),
        ], [
            'user_id'
                => '[user_id]',
            'vod_id'
                => '[vod_id]',
        ]];
    }

    public function show()
    {
        return [ClipFindingService::class];
    }
}
