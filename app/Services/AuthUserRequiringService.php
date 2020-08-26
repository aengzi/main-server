<?php

namespace App\Services;

use App\Service;
use App\Models\User;
use App\Services\TokenDecryptingService;
use Illuminate\Support\Facades\Auth;

class AuthUserRequiringService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'auth_user'
                => 'authorized user',

            'auth_user_id'
                => 'id of {{auth_user}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'auth_user' => ['auth_user', function ($authUser) {

                Auth::setUser($authUser);
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'auth_user' => ['payload', function ($payload) {

                return User::find($payload['uid']);
            }],

            'auth_user_id' => ['auth_user', function ($authUser) {

                return $authUser->getKey();
            }],

            'payload_keys' => [function () {

                return ['uid'];
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
            'auth_user'
                => ['required']
        ];
    }

    public static function getArrTraits()
    {
        return [
            TokenDecryptingService::class
        ];
    }
}
