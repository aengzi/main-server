<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use FunctionalCoding\Service;
use FunctionalCoding\Illuminate\Service\FindService;
use Illuminate\Extend\Service\Token\TokenDecryptionService;
use Illuminate\Support\Facades\Auth;

class AuthUserFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'current_time'
                => 'current time',

            'id'
                => 'id of {{model}}',

            'model'
                => 'authorized user',

            'payload_expired_at'
                => 'expired_at of payload of {{token}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => function ($result) {

                Auth::setUser($result);
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'current_time' => function () {

                return Carbon::now('UTC')->format('Y-m-d H:i:s');
            },

            'id' => function ($payload) {

                return $payload['uid'];
            },

            'model_class' => function () {

                return User::class;
            },

            'payload' => function ($token) {

                return [TokenDecryptionService::class, [
                    'token'
                        => $token,
                    'payload_keys'
                        => ['uid', 'expired_at', 'verified'],
                ], [
                    'token'
                        => '{{token}}',
                ]];
            },

            'payload_expired_at' => function ($payload) {

                return $payload['expired_at'];
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'model'
                => ['current_time:strict'],
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'current_time'
                => ['before:{{payload_expired_at}}'],

            'token'
                => ['required'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            FindService::class,
        ];
    }
}
