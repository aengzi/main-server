<?php

namespace App\Services\YtbCommentThread;

use App\Models\YtbCommentThread;
use App\Models\YtbVideo;
use FunctionalCoding\ORM\Eloquent\Service\PaginationListService;
use FunctionalCoding\Service;

class YtbCommentThreadPagingService extends Service
{
    public static function getBindNames()
    {
        return [
            'video' => 'youtube_video for {{video_id}}',
        ];
    }

    public static function getCallbacks()
    {
        return [
            'query.video' => function ($query, $video) {
                $query->where('video_id', $video->getKey());
            },
        ];
    }

    public static function getLoaders()
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

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'video' => ['not_null'],

            'video_id' => ['integer'],
        ];
    }

    public static function getTraits()
    {
        return [
            PaginationListService::class,
        ];
    }
}
