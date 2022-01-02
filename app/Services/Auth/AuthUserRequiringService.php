<?php

namespace App\Services\Auth;

use FunctionalCoding\Service;

class AuthUserRequiringService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'auth_user' => function ($token) {
                return [AuthUserFindingService::class, [
                    'token' => $token,
                ], [
                    'token' => '{{token}}',
                ]];
            },

            'auth_user_id' => function ($authUser) {
                return $authUser->getKey();
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
            'token' => ['required'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
