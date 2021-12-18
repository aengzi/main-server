<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;

class PostUpdatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'post' => 'post for {{id}}',

            'user_id' => 'user_id of {{post}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'post.content' => function ($content, $post) {
                $post->content = $content;
            },

            'post.title' => function ($post, $title) {
                $post->title = $title;
            },

            'post.type' => function ($post, $type) {
                $post->type = $type;
            },

            'result' => function ($result) {
                $result->save();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'post' => function ($id) {
                return Post::find($id);
            },

            'result' => function ($post) {
                return $post;
            },

            'user_id' => function ($post) {
                return $post->user_id;
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
            'id' => ['required', 'integer'],

            'content' => ['required', 'string'],

            'post' => ['not_null'],

            'title' => ['required', 'string'],

            'type' => ['required', 'string'],

            'user_id' => ['same:{{auth_user_id}}'],
        ];
    }

    public static function getTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
