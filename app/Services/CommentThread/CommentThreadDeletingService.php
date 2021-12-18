<?php

namespace App\Services\CommentThread;

use App\Models\CommentThread;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;
use Illuminate\Database\Eloquent\Relations\Relation;

class CommentThreadDeletingService extends Service
{
    public static function getBindNames()
    {
        return [
            'thread' => 'comment_thread for {{id}}',

            'user_id' => 'user_id of {{thread}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'result' => function ($thread) {
                $thread->delete();

                $count = CommentThread::query()
                    ->where('related_id', $thread->related_id)
                    ->where('related_type', $thread->related_type)
                    ->count()
                ;

                $related = Relation::morphMap()[$thread->related_type]::find($thread->related_id);
                $related->thread_count = $count;
                $related->save();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'result' => function () {
                return null;
            },

            'thread' => function ($id) {
                return CommentThread::find($id);
            },

            'user_id' => function ($thread) {
                return $thread->user_id;
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [
            'result' => ['user_id'],
        ];
    }

    public static function getRuleLists()
    {
        return [
            'id' => ['required', 'integer'],

            'thread' => ['not_null'],

            'user_id' => ['same:{{auth_user_id}}'],
        ];
    }

    public static function getTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
