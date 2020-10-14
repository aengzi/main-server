<?php

namespace App\Services\Post;

use App\Service;
use App\Models\Post;
use App\Services\AuthUserRequiringService;

class PostCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result.auth_user' => ['auth_user', 'result', function ($authUser, $result) {

                $result->setRelation('user', $authUser);
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => ['auth_user', 'content', 'title', 'type', function ($authUser, $content, $title, $type) {

                return Post::create([
                    'user_id'
                        => $authUser->getKey(),
                    'content'
                        => $content,
                    'title'
                        => $title,
                    'type'
                        => $type
                ]);
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
            'content'
                => ['required', 'string'],

            'title'
                => ['required', 'string'],

            'type'
                => ['required', 'string', 'in:free']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
