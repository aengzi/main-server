<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Dislike\DislikePagingService;
use App\Services\Dislike\DislikeCreatingService;
use App\Services\Dislike\DislikeDeletingService;
use Illuminate\Support\Facades\Request;

class DislikeController extends Controller
{
    public function destroy()
    {
        return [DislikeDeletingService::class, [
            'dislike_id'
                => Request::route('id'),
        ], [
            'dislike_id'
                => Request::route('id'),
        ]];
    }

    public function index()
    {
        return [DislikePagingService::class, [
            'related_id'
                => $this->input('related_id'),
            'related_type'
                => $this->input('related_type'),
            'related_types'
                => $this->input('related_types'),
            'user_id'
                => $this->input('user_id'),
        ], [
            'related_id'
                => '[related_id]',
            'related_type'
                => '[related_type]',
            'related_types'
                => '[related_types]',
            'user_id'
                => '[user_id]',
        ]];
    }

    public function store()
    {
        return [DislikeCreatingService::class, [
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
}
