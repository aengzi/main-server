<?php

namespace App\Services\CommentReply;

use App\Models\CommentReply;
use App\Models\CommentThread;
use App\Services\Auth\AuthUserRequiringService;
use Illuminate\Extend\Service;

class CommentReplyCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'thread'
                => 'comment_thread for {{thread_id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => function ($result) {

                $count = CommentReply::query()
                    ->where('thread_id', $result->thread_id)
                    ->count();

                $thread = $result->thread;
                $thread->reply_count = $count;
                $thread->save();
            },

            'result.auth_user' => function ($authUser, $result) {

                $result->setRelation('user', $authUser);
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => function ($authUser, $message, $thread) {

                return CommentReply::create([
                    'user_id'
                        => $authUser->getKey(),
                    'message'
                        => $message,
                    'thread_id'
                        => $thread->getKey(),
                ]);
            },

            'thread' => function ($threadId) {

                return CommentThread::find($threadId);
            },
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
            AuthUserRequiringService::class,
        ];
    }
}
