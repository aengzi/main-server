<?php

namespace App\Services\YtbCommentReply;

use App\Service;
use App\Models\YtbCommentReply;
use App\Models\YtbCommentThread;
use App\Services\CursoringService;

class YtbCommentReplyCursoringService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'thread'
                => 'youtube_comment_thread for {{thread_id}}',

            'cursor'
                => 'youtube_comment_reply for {{cursor_id}}'
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

                return ['thread'];
            }],

            'model_class' => [function () {

                return YtbCommentReply::class;
            }],

            'thread' => ['thread_id', function ($threadId) {

                return YtbCommentThread::find($threadId);
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
