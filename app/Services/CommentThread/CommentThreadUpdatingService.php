<?php

namespace App\Services\CommentThread;

use App\Models\CommentThread;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;

class CommentThreadUpdatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'result' => 'comment_thread for {{id}}',

            'user_id' => 'user_id of {{result}}',
        ];
    }

    public static function getCallbacks()
    {
        return [
            'result' => function ($message, $result) {
                $result->message = $message;
                $result->save();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'result' => function ($id) {
                return CommentThread::find($id);
            },

            'user_id' => function ($result) {
                return $result->user_id;
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

            'message' => ['required', 'string'],

            'result' => ['not_null'],

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
