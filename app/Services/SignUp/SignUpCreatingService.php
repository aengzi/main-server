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
            'user' => 'user who has same email with payload\'s email of {{auth_token}}',
        ];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'payload' => function ($authToken) {
                return [TokenDecryptionService::class, [
                    'token' => $authToken,
                ], [
                    'token' => '{{auth_token}}',
                ]];
            },

            'payload_email' => function ($payload) {
                return isset($payload['email']) ? $payload['email'] : '';
            },

            'payload_nick' => function ($payload) {
                return isset($payload['nick']) ? $payload['nick'] : '';
            },

            'payload_password' => function ($payload) {
                return isset($payload['password']) ? $payload['password'] : '';
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

            'payload_email' => ['required', 'string'],

            'payload_nick' => ['required', 'string'],

            'payload_password' => ['required', 'string'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
