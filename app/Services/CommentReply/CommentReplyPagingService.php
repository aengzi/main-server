<?php

namespace App\Services\CommentReply;

use App\Models\CommentReply;
use App\Models\CommentThread;
use FunctionalCoding\ORM\Eloquent\Service\PaginationListService;
use FunctionalCoding\Service;

class CommentReplyPagingService extends Service
{
    public static function getBindNames()
    {
        return [
            'cursor' => 'comment_reply for {{cursor_id}}',

            'thread' => 'comment_thread for {{thread_id}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'query.thread' => function ($query, $thread) {
                $query->where('thread_id', $thread->getKey());
            },
        ];
    }

    public static function getLoaders()
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

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'thread' => ['not_null'],

            'thread_id' => ['required', 'integer'],
        ];
    }

    public static function getTraits()
    {
        return [
            PaginationListService::class,
        ];
    }
}
