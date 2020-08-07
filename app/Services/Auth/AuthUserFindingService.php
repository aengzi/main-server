<?php

namespace App\Services\Auth;

use App\Service;
use App\Models\User;
use App\Services\FindingService;
use App\Services\AuthUserRequiringService;

class AuthUserFindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'id'
                => 'id of user for {{token}}',

            'result'
                => 'user for {{token}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return [];
            }],

            'id' => ['auth_user', function ($authUser) {

                return $authUser->getKey();
            }],

            'result' => ['auth_user', function ($authUser) {

                return $authUser;
            }],

            'model_class' => [function () {

                return User::class;
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [];
    }

    public static function getArrTraits()
    {
        return [
            FindingService::class,
            AuthUserRequiringService::class
        ];
    }
}
