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
            'is_win'
                => $this->input('is_win'),
            'multi_kill_types'
                => $this->input('multi_kill_types'),
        ], [
            'champion_ids'
                => '[champion_ids]',
            'is_win'
                => '[is_win]',
            'multi_kill_types'
                => '[multi_kill_types]',
        ]];
    }

    public function show()
    {
        return [LolGameFindingService::class];
    }
}
