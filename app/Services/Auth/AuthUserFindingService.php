<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use FunctionalCoding\JWT\Service\TokenDecryptionService;
use FunctionalCoding\ORM\Eloquent\Service\FindService;
use FunctionalCoding\Service;
use Illuminate\Support\Facades\Auth;

class AuthUserFindingService extends Service
{
    public static function getBindNames()
    {
        return [
            'current_time' => 'current time',

            'id' => 'id of {{model}}',

            'model' => 'authorized user',

            'payload_expired_at' => 'expired_at of payload of {{auth_token}}',
        ];
    }

    public static function getCallbacks()
    {
        return [
            'result' => function ($result) {
                Auth::setUser($result);
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'available_expands' => function () {
                return [];
            },

            'current_time' => function () {
                return Carbon::now('UTC')->format('Y-m-d H:i:s');
            },

            'id' => function ($payload) {
                return $payload['uid'];
            },

            'model_class' => function () {
                return User::class;
            },

            'payload' => function ($authToken) {
                return [TokenDecryptionService::class, [
                    'token' => $authToken,
                    'secret_key' => file_get_contents(app()->storagePath('app/id_rsa')),
                ], [
                    'token' => '{{auth_token}}',
                ]];
            },

            'payload_expired_at' => function ($payload) {
                return $payload['expired_at'];
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [
            'model' => ['current_time'],
        ];
    }

    public static function getRuleLists()
    {
        return [
            'payload_expired_at' => ['required'],

            'current_time' => ['before:{{payload_expired_at}}'],

            'auth_token' => ['required'],
        ];
    }

    public static function getTraits()
    {
        return [
            FindService::class,
        ];
    }
}
