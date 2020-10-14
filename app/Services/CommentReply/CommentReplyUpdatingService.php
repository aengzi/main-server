<?php

namespace App\Services\CommentReply;

use App\Models\CommentReply;
use App\Services\Auth\AuthUserRequiringService;
use Illuminate\Extend\Service;

class CommentReplyUpdatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'result'
                => 'comment_reply for {{id}}',

            'user_id'
                => 'user_id of {{result}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => ['message', 'result', function ($message, $result) {

                $result->message = $message;
                $result->save();
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => ['id', function ($id) {

                return CommentReply::find($id);
            }],

            'user_id' => ['result', function ($result) {

                return $result->user_id;
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
            AuthUserRequiringService::class,
        ];
    }
}
