<?php

namespace App\Services\CommentReply;

use App\Models\CommentReply;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;

class CommentReplyDeletingService extends Service
{
    public static function getBindNames()
    {
        return [
            'reply' => 'comment_reply for {{id}}',

            'user_id' => 'user_id of {{reply}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'result' => function ($reply) {
                $reply->delete();

                $count = CommentReply::query()
                    ->where('thread_id', $reply->thread_id)
                    ->count()
                ;

                $thread = $reply->thread;
                $thread->reply_count = $count;
                $thread->save();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'reply' => function ($id) {
                return CommentReply::find($id);
            },

            'result' => function () {
                return null;
            },

            'user_id' => function ($reply) {
                return $reply->user_id;
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [
            'result' => ['user_id'],
        ];
    }

    public static function getRuleLists()
    {
        return [
            'id' => ['required', 'integer'],

            'reply' => ['not_null'],

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
