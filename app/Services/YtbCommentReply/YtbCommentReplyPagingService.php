<?php

namespace App\Services\YtbCommentReply;

use App\Models\YtbCommentReply;
use App\Models\YtbCommentThread;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Database\PaginationListService;

class YtbCommentReplyPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'cursor'
                => 'youtube_comment_reply for {{cursor_id}}',

            'thread'
                => 'youtube_comment_thread for {{thread_id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.thread' => ['query', 'thread', function ($query, $thread) {

                $query->where('thread_id', $thread->getKey());
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return ['thread'];
            }],

            'cursor' => ['cursor_id', 'model_class', function ($cursorId, $modelClass) {

                return $modelClass::find($cursorId);
            }],

            'model_class' => [function () {

                return YtbCommentReply::class;
            }],

            'thread' => ['thread_id', function ($threadId) {

                return YtbCommentThread::find($threadId);
            }],
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