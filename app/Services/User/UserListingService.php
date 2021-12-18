<?php

namespace App\Services\User;

use App\Models\User;
use FunctionalCoding\ORM\Eloquent\Service\ListService;
use FunctionalCoding\Service;

class UserListingService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbackLists()
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

    public static function getLoaders()
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

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'email' => ['string', 'email'],

            'nick' => ['string', 'min:2', 'max:12'],
        ];
    }

    public static function getTraits()
    {
        return [
            ListService::class,
        ];
    }
}
