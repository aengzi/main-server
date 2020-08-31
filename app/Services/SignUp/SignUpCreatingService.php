<?php

namespace App\Services\SignUp;

use App\Service;
use App\Models\User;
use App\Services\TokenDecryptingService;

class SignUpCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'user'
                => 'user who has same email with payload\'s email of {{token}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'payload' => ['token', function ($token) {

                return [TokenDecryptingService::class, [
                    'token'
                        => $token,
                    'payload_keys'
                        => ['email', 'password', 'nick', 'verified'],
                ], [
                    'token'
                        => '{{token}}',
                ]];
            }],

            'user' => ['payload', function ($payload) {

                return User::lockForUpdate()->where('email', $payload['email'])->first();
            }],

            'result' => ['payload', function ($payload) {

                $user = User::create([
                    'email'    => $payload['email'],
                    'password' => $payload['password'],
                    'nick'     => $payload['nick'],
                ]);

                return $user;
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'result'
                => ['user']
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'user'
                => ['null']
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
