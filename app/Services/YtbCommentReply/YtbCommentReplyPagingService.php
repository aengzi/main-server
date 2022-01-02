<?php

namespace App\Services\YtbCommentReply;

use App\Models\YtbCommentReply;
use App\Models\YtbCommentThread;
use FunctionalCoding\ORM\Eloquent\Service\PaginationListService;
use FunctionalCoding\Service;

class YtbCommentReplyPagingService extends Service
{
    public static function getBindNames()
    {
        return [
            'cursor' => 'youtube_comment_reply for {{cursor_id}}',

            'thread' => 'youtube_comment_thread for {{thread_id}}',
        ];
    }

    public static function getCallbacks()
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
                return ['thread'];
            },

            'cursor' => function ($cursorId, $modelClass) {
                return $modelClass::find($cursorId);
            },

            'model_class' => function () {
                return YtbCommentReply::class;
            },

            'thread' => function ($threadId) {
                return YtbCommentThread::find($threadId);
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
