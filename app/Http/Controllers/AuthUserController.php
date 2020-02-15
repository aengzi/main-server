<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\Auth\AuthUserFindingService;
use Illuminate\Support\Facades\Request;

class AuthUserController extends Controller
{
    public function index()
    {
        return [AuthUserFindingService::class, [
            'fields'
                => $this->input('fields'),
            'expands'
                => $this->input('expands'),
            'token'
                => Request::bearerToken() ? Request::bearerToken() : new \stdClass
        ], [
            'fields'
                => '[fields]',
            'expands'
                => '[expands]',
            'token'
                => 'header[authorization]'
        ]];
    }
}
