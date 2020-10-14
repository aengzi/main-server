<?php

namespace App\Services\CommentReply;

use App\Service;
use App\Models\CommentReply;
use App\Services\AuthUserRequiringService;

class CommentReplyDeletingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'reply'
                => 'comment_reply for {{id}}',

            'user_id'
                => 'user_id of {{reply}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => ['reply', function ($reply) {

                $reply->delete();

                $count = CommentReply::query()
                    ->where('thread_id', $reply->thread_id)
                    ->count();

                $thread = $reply->thread;
                $thread->reply_count = $count;
                $thread->save();
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'reply' => ['id', function ($id) {

                return CommentReply::find($id);
            }],

            'result' => [function () {

                return null;
            }],

            'user_id' => ['reply', function ($reply) {

                return $reply->user_id;
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'result'
                => ['user_id'],
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'id'
                => ['required', 'integer'],

            'reply'
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
