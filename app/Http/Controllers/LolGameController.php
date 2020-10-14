<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\LolGame\LolGameFindingService;
use App\Services\LolGame\LolGamePagingService;
use Illuminate\Support\Facades\Request;

class LolGameController extends Controller
{
    public function index()
    {
        return [LolGamePagingService::class, [
            'champion_ids'
                => $this->input('champion_ids'),
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'is_win'
                => $this->input('is_win'),
            'limit'
                => $this->input('limit'),
            'multi_kill_types'
                => $this->input('multi_kill_types'),
            'order_by'
                => $this->input('order_by', 'game_creation desc'),
            'page'
                => $this->input('page'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : ''
        ], [
            'champion_ids'
                => '[champion_ids]',
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'is_win'
                => '[is_win]',
            'limit'
                => '[limit]',
            'multi_kill_types'
                => '[multi_kill_types]',
            'order_by'
                => '[order_by]',
            'page'
                => '[page]',
            'token'
                => 'header[authorization]'
        ]];
    }

    public function show()
    {
        return [LolGameFindingService::class, [
            'expands'
                => $this->input('expands'),
            'fields'
                => $this->input('fields'),
            'id'
                => Request::route('id'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : ''
        ], [
            'expands'
                => '[expands]',
            'fields'
                => '[fields]',
            'id'
                => Request::route('id'),
            'token'
                => 'header[authorization]'
        ]];
    }
}
