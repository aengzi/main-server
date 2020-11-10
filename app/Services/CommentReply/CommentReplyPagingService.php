<?php

namespace App\Services\CommentReply;

use App\Models\CommentReply;
use App\Models\CommentThread;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Database\PaginationListService;

class CommentReplyPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'cursor'
                => 'comment_reply for {{cursor_id}}',

            'thread'
                => 'comment_thread for {{thread_id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.thread' => function ($query, $thread) {

                $query->where('thread_id', $thread->getKey());
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => function () {

                return ['user', 'thread'];
            },

            'cursor' => function ($cursorId, $modelClass) {

                return $modelClass::find($cursorId);
            },

            'model_class' => function () {

                return CommentReply::class;
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
            'thread'
                => ['not_null'],

            'thread_id'
                => ['required', 'integer']
        ];
    }

    public static function getArrTraits()
    {
        return [
            PaginationListService::class,
        ];
    }
}
