<?php

namespace App\Services\User;

use App\Models\User;
use App\Service;
use App\Services\ListingService;

class UserListingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.nick' => ['query', 'nick', function ($query, $nick) {

                $query->where('nick', $nick);
            }],
            'query.email' => ['query', 'email', function ($query, $email) {

                $query->where('email', $email);
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return [];
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
            ListingService::class
        ];
    }
}
