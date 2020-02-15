<?php

namespace App\Services\CommentReply;

use App\Service;
use App\Models\CommentReply;
use App\Models\CommentThread;
use App\Services\AuthUserRequiringService;

class CommentReplyCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'thread'
                => 'comment_thread for {{thread_id}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result.auth_user' => ['result', 'auth_user', function ($result, $authUser) {

                $result->setRelation('user', $authUser);
            }],

            'result' => ['result', function ($result) {

                $count = CommentReply::query()
                    ->where('thread_id', $result->thread_id)
                    ->count();

                $thread = $result->thread;
                $thread->reply_count = $count;
                $thread->save();
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => ['auth_user', 'message', 'thread', function ($authUser, $message, $thread) {

                return CommentReply::create([
                    'user_id'
                        => $authUser->getKey(),
                    'message'
                        => $message,
                    'thread_id'
                        => $thread->getKey(),
                ]);
            }],

            'thread' => ['thread_id', function ($threadId) {

                return CommentThread::find($threadId);
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
            'message'
                => ['required', 'string'],

            'thread'
                => ['not_null'],

            'thread_id'
                => ['required', 'integer']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class
        ];
    }
}
