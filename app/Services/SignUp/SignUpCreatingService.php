<?php

namespace App\Services\SignUp;

use App\Models\User;
use FunctionalCoding\JWT\TokenDecryptionService;
use FunctionalCoding\Service;

class SignUpCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'user' => 'user who has same email with payload\'s email of {{token}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'payload' => function ($token) {
                return [TokenDecryptionService::class, [
                    'token' => $token,
                    'payload_keys' => ['email', 'password', 'nick', 'verified'],
                ], [
                    'token' => '{{token}}',
                ]];
            },

            'result' => function ($payload) {
                return User::create([
                    'email' => $payload['email'],
                    'password' => $payload['password'],
                    'nick' => $payload['nick'],
                ]);
            },

            'user' => function ($payload) {
                return User::lockForUpdate()->where('email', $payload['email'])->first();
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'result' => ['user'],
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'user' => ['null'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
