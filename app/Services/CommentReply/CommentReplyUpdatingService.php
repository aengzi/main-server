<?php

namespace App\Services\CommentReply;

use App\Service;
use App\Models\CommentReply;
use App\Services\AuthUserRequiringService;

class CommentReplyUpdatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'user_id'
                => 'user_id of {{result}}',

            'result'
                => 'comment_reply for {{id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => ['result', 'message', function ($result, $message) {

                $result->message = $message;
                $result->save();
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'user_id' => ['result', function ($result) {

                return $result->user_id;
            }],

            'result' => ['id', function ($id) {

                return CommentReply::find($id);
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

            'message'
                => ['required', 'string'],

            'result'
                => ['not_null'],

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
