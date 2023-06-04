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
            'auth_user' => function ($authToken) {
                return [AuthUserFindingService::class, [
                    'auth_token' => $authToken,
                ], [
                    'auth_token' => '{{auth_token}}',
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
            'auth_token' => ['required'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
