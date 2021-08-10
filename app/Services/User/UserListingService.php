<?php

namespace App\Services\User;

use App\Models\User;
use FunctionalCoding\Service;
use FunctionalCoding\Illuminate\Service\ListService;

class UserListingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.email' => function ($email, $query) {

                $query->where('email', $email);
            },

            'query.nick' => function ($nick, $query) {

                $query->where('nick', $nick);
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => function () {

                return [];
            },

            'model_class' => function () {

                return User::class;
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
            'email'
                => ['string', 'email'],

            'nick'
                => ['string', 'min:2', 'max:12']
        ];
    }

    public static function getArrTraits()
    {
        return [
            ListService::class,
        ];
    }
}
