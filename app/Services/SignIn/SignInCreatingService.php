<?php

namespace App\Services\SignIn;

use App\Models\User;
use FunctionalCoding\JWT\TokenEncryptionService;
use FunctionalCoding\Service;
use Illuminate\Support\Facades\Hash;

class SignInCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'user' => 'matching user for {{email}} and {{password}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'payload' => function ($user) {
                return [
                    'expired_at' => '9999-12-31 12:59:59',
                    'uid' => $user->getKey(),
                    'verified' => true,
                ];
            },

            'result' => function ($payload) {
                return [TokenEncryptionService::class, [
                    'payload' => $payload,
                ]];
            },

            'user' => function ($email, $password) {
                $user = User::lockForUpdate()->where('email', $email)->first();

                if (!empty($user) && Hash::check($password, $user->password)) {
                    return $user;
                }
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
            'email' => ['required', 'string', 'email'],

            'password' => ['required', 'string'],

            'user' => ['required'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
