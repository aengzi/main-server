<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\LolGame\LolGameFindingService;
use App\Services\LolGame\LolGamePagingService;
use Illuminate\Support\Facades\Request;

class LolGameController extends Controller
{
    public static function index()
    {
        return [LolGamePagingService::class, [
            'champion_ids'
                => static::input('champion_ids'),
            'is_win'
                => static::input('is_win'),
            'multi_kill_types'
                => static::input('multi_kill_types'),
        ], [
            'champion_ids'
                => '[champion_ids]',
            'is_win'
                => '[is_win]',
            'multi_kill_types'
                => '[multi_kill_types]',
        ]];
    }

    public static function show()
    {
        return [LolGameFindingService::class];
    }
}
