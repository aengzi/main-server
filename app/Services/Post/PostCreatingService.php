<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;

class PostCreatingService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'result.auth_user' => function ($authUser, $result) {
                $result->setRelation('user', $authUser);
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'result' => function ($authUser, $content, $title, $type) {
                return Post::create([
                    'user_id' => $authUser->getKey(),
                    'content' => $content,
                    'title' => $title,
                    'type' => $type,
                ]);
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
            'content' => ['required', 'string'],

            'title' => ['required', 'string'],

            'type' => ['required', 'string', 'in:free'],
        ];
    }

    public static function getTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
