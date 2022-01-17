<?php

namespace App\Services\SignIn;

use App\Models\User;
use FunctionalCoding\JWT\Service\TokenEncryptionService;
use FunctionalCoding\Service;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SignInCreatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'user' => 'matching user for {{email}} and {{password}}',
        ];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
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
                    'public_key' => File::get(storage_path('app/id_rsa.pub')),
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

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'email' => ['required', 'string', 'email'],

            'password' => ['required', 'string'],

            'user' => ['required'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
