<?php

namespace App\Services\CommentReply;

use App\Service;
use App\Models\CommentReply;
use App\Models\CommentThread;
use App\Services\CursoringService;

class CommentReplyCursoringService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'thread'
                => 'comment_thread for {{thread_id}}',

            'cursor'
                => 'comment_reply for {{cursor_id}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.thread' => ['query', 'thread', function ($query, $thread) {

                $query->where('thread_id', $thread->getKey());
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return ['user', 'thread'];
            }],

            'model_class' => [function () {

                return CommentReply::class;
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
            'thread'
                => ['not_null'],

            'thread_id'
                => ['required', 'integer']
        ];
    }

    public static function getArrTraits()
    {
        return [
            CursoringService::class
        ];
    }
}
