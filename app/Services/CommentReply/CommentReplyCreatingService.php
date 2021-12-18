<?php

namespace App\Services\CommentReply;

use App\Models\CommentReply;
use App\Models\CommentThread;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;

class CommentReplyCreatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'thread' => 'comment_thread for {{thread_id}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'result' => function ($result) {
                $count = CommentReply::query()
                    ->where('thread_id', $result->thread_id)
                    ->count()
                ;

                $thread = $result->thread;
                $thread->reply_count = $count;
                $thread->save();
            },

            'result.auth_user' => function ($authUser, $result) {
                $result->setRelation('user', $authUser);
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'result' => function ($authUser, $message, $thread) {
                return CommentReply::create([
                    'user_id' => $authUser->getKey(),
                    'message' => $message,
                    'thread_id' => $thread->getKey(),
                ]);
            },

            'thread' => function ($threadId) {
                return CommentThread::find($threadId);
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
            'message' => ['required', 'string'],

            'thread' => ['not_null'],

            'thread_id' => ['required', 'integer'],
        ];
    }

    public static function getTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
