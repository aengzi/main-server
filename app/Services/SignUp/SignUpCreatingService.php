<?php

namespace App\Services\SignUp;

use App\Models\User;
use FunctionalCoding\JWT\Service\TokenDecryptionService;
use FunctionalCoding\Service;

class SignUpCreatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'user' => 'user who has same email with payload\'s email of {{token}}',
        ];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
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

    public static function getPromiseLists()
    {
        return [
            'result' => ['user'],
        ];
    }

    public static function getRuleLists()
    {
        return [
            'user' => ['null'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
