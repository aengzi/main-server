<?php

namespace App\Services\Post;

use App\Service;
use App\Models\Post;
use App\Services\AuthUserRequiringService;

class PostUpdatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'user_id'
                => 'user_id of {{post}}',

            'post'
                => 'post for {{id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'post.content' => ['post', 'content', function ($post, $content) {

                $post->content = $content;
            }],

            'post.title' => ['post', 'title', function ($post, $title) {

                $post->title = $title;
            }],

            'post.type' => ['post', 'type', function ($post, $type) {

                $post->type = $type;
            }],

            'result' => ['result', function ($result) {

                $result->save();
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'post' => ['id', function ($id) {

                return Post::find($id);
            }],

            'result' => ['post', function ($post) {

                return $post;
            }],

            'user_id' => ['post', function ($post) {

                return $post->user_id;
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
            'id'
                => ['required', 'integer'],

            'content'
                => ['required', 'string'],

            'post'
                => ['not_null'],

            'title'
                => ['required', 'string'],

            'type'
                => ['required', 'string'],

            'user_id'
                => ['same:{{auth_user_id}}']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class
        ];
    }
}
