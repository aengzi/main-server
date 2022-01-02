<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;

class PostDeletingService extends Service
{
    public static function getBindNames()
    {
        return [
            'post' => 'post for {{id}}',

            'post_user_id' => 'user_id of {{post}}',
        ];
    }

    public static function getCallbacks()
    {
        return [
            'result' => function ($post) {
                $post->content = null;
                $post->delete();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'post' => function ($id) {
                return Post::find($postId);
            },

            'post_user_id' => function ($post) {
                return $post->user_id;
            },

            'result' => function () {
                return null;
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
            'post' => ['not_null'],

            'id' => ['required', 'integer'],

            'post_user_id' => ['same:{{auth_user_id}}'],
        ];
    }

    public static function getTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
