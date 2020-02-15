<?php

namespace App\Services\CommentThread;

use App\Service;
use App\Models\CommentThread;
use App\Services\AuthUserRequiringService;
use Illuminate\Database\Eloquent\Relations\Relation;

class CommentThreadDeletingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'thread'
                => 'comment_thread for {{id}}',

            'user_id'
                => 'user_id of {{thread}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => ['thread', function ($thread) {

                $thread->delete();

                $count = CommentThread::query()
                    ->where('related_id', $thread->related_id)
                    ->where('related_type', $thread->related_type)
                    ->count();

                $related = Relation::morphMap()[$thread->related_type]::find($thread->related_id);
                $related->thread_count = $count;
                $related->save();
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => [function () {

                return null;
            }],

            'thread' => ['id', function ($id) {

                return CommentThread::find($id);
            }],

            'user_id' => ['thread', function ($thread) {

                return $thread->user_id;
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'result'
                => ['user_id']
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'id'
                => ['required', 'integer'],

            'thread'
                => ['not_null'],

            'user_id'
                => ['same:{{auth_user_id}}']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class
        ];
    }
}
