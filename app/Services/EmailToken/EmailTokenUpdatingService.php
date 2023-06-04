<?php

namespace App\Services\EmailToken;

use Carbon\Carbon;
use FunctionalCoding\JWT\Service\TokenDecryptionService;
use FunctionalCoding\JWT\Service\TokenEncryptionService;
use FunctionalCoding\Service;
use Illuminate\Support\Facades\File;

class EmailTokenUpdatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'current_time' => 'current time',

            'payload_code' => ' code of payload of {{token}}',

            'payload_expired_at' => ' expired time of payload of {{token}}',
        ];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'current_time' => function () {
                return Carbon::now('UTC')->format('Y-m-d H:i:s');
            },

            'payload' => function ($authToken) {
                return [TokenDecryptionService::class, [
                    'token' => $authToken,
                ], [
                    'token' => '{{auth_token}}',
                ]];
            },

            'payload_code' => function ($payload) {
                return isset($payload['code']) ? $payload['code'] : '';
            },

            'payload_expired_at' => function ($payload) {
                return isset($payload['expired_at']) ? $payload['expired_at'] : '';
            },

            'result' => function ($payload) {
                return [TokenEncryptionService::class, [
                    'payload' => array_diff(
                        array_merge($payload, ['verified' => true]),
                        ['code'],
                    ),
                    'public_key' => File::get(storage_path('app/id_rsa.pub')),
                ]];
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'code' => ['required', 'same:{{payload_code}}'],

            'current_time' => ['before:{{payload_expired_at}}'],

            'payload_code' => ['required', 'string'],

            'payload_expired_at' => ['required', 'string'],

            'auth_token' => ['required', 'string'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
