<?php

namespace App\Services;

use App\Service;
use App\Models\User;
use App\Services\TokenDecryptingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthUserRequiringService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'auth_user'
                => 'authorized user',

            'auth_user_id'
                => 'id of {{auth_user}}',

            'current_time'
                => 'current time',

            'payload_expired_at'
                => 'expired_at of payload of {{token}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'auth_user' => ['auth_user', function ($authUser) {

                Auth::setUser($authUser);
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'auth_user' => ['payload', function ($payload) {

                return User::find($payload['uid']);
            }],

            'auth_user_id' => ['auth_user', function ($authUser) {

                return $authUser->getKey();
            }],

            'current_time' => [function () {

                return Carbon::now('UTC')->format('Y-m-d H:i:s');
            }],

            'payload' => ['token', function ($token) {

                return [TokenDecryptingService::class, [
                    'token'
                        => $token,
                    'payload_keys'
                        => ['uid', 'expired_at', 'verified'],
                ], [
                    'token'
                        => '{{token}}',
                ]];
            }],

            'payload_expired_at' => ['payload', function ($payload) {

                return $payload['expired_at'];
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'auth_user'
                => ['required'],

            'current_time'
                => ['before:{{payload_expired_at}}'],

            'token'
                => ['required'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}