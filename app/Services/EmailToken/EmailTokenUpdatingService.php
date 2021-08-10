<?php

namespace App\Services\EmailToken;

use Carbon\Carbon;
use FunctionalCoding\JWT\TokenDecryptionService;
use FunctionalCoding\JWT\TokenEncryptionService;
use FunctionalCoding\Service;

class EmailTokenUpdatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'current_time' => 'current time',

            'payload_code' => ' code of payload of {{token}}',

            'payload_expired_at' => ' expired time of payload of {{token}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'current_time' => function () {
                return Carbon::now('UTC')->format('Y-m-d H:i:s');
            },

            'payload' => function ($token) {
                return [TokenDecryptionService::class, [
                    'token' => $token,
                    'payload_keys' => ['code', 'expired_at'],
                ], [
                    'token' => '{{token}}',
                ]];
            },

            'payload_code' => function ($payload) {
                return $payload['code'];
            },

            'payload_expired_at' => function ($payload) {
                return $payload['expired_at'];
            },

            'result' => function ($payload) {
                unset($payload['code']);

                return [TokenEncryptionService::class, [
                    'payload' => array_merge($payload, ['verified' => true]),
                ]];
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'current_time' => ['before:{{payload_expired_at}}'],

            'code' => ['required', 'same:{{payload_code}}'],

            'token' => ['required', 'string'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
