<?php

namespace App\Services\Auth;

use App\Services\Auth\AuthUserFindingService;
use Illuminate\Extend\Service;

class AuthUserRequiredService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'auth_user' => ['token', function ($token) {

                return [AuthUserFindingService::class, [
                    'token'
                        => $token,
                ], [
                    'token'
                        => '{{token}}',
                ]];
            }],

            'auth_user_id' => ['auth_user', function ($authUser) {

                return $authUser->getKey();
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'token'
                => ['required'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
