<?php

namespace App\Services\SignIn;

use App\Service;
use App\Models\User;
use App\Services\TokenEncryptingService;
use Illuminate\Support\Facades\Hash;

class SignInCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'user'
                => 'matching user for {{email}} and {{password}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'user' => ['email', 'password', function ($email, $password) {

                $user = User::where('email', $email)->first();

                if( !empty($user) && Hash::check($password, $user->password) )
                {
                    return $user;
                }
            }],

            'payload' => ['user', function ($user) {

                return [
                    'uid' => $user->getKey()
                ];
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'email'
                => ['required', 'string', 'email'],

            'password'
                => ['required', 'string'],

            'user'
                => ['required']
        ];
    }

    public static function getArrTraits()
    {
        return [
            TokenEncryptingService::class
        ];
    }
}
