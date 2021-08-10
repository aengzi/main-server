<?php

namespace App\Services\YtbCommentThread;

use App\Models\User;
use App\Models\YtbCommentThread;
use App\Models\YtbVideo;
use FunctionalCoding\Service;
use Illuminate\Extend\Service\Database\PaginationListService;

class YtbCommentThreadPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'video'
                => 'youtube_video for {{video_id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.video' => function ($query, $video) {

                $query->where('video_id', $video->getKey());
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => function () {

                return ['replies'];
            },

            'cursor' => function ($cursorId, $modelClass) {

                return $modelClass::find($cursorId);
            },

            'model_class' => function () {

                return YtbCommentThread::class;
            },

            'video' => function ($videoId) {

                return YtbVideo::find($relatedId);
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
            'video'
                => ['not_null'],

            'video_id'
                => ['integer']
        ];
    }

    public static function getArrTraits()
    {
        return [
            PaginationListService::class,
        ];
    }
}
