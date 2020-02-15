<?php

namespace App\Services\Clip;

use App\Service;
use App\Models\AftvFile;
use App\Models\Vod;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Str;

class ClipCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'diff_timestamp'
                => 'diff timestamp between {{started_at}} and {{ended_at}}',

            'vod'
                => 'vod for {{vod_id}}',

            'vod_ended_at'
                => 'ended_at of {{vod}}',

            'vod_started_at'
                => 'started_at of {{vod}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'files' => ['files', function ($files) {

                $files->load(['m3u8']);
            }],

            'clip_vod.files' => ['clip_vod', 'files', 'm3u8_string', function ($clipVod, $files, $m3u8String) {

                $bucketName = $clipVod->getBucketNameAttribute();
                $storage = new StorageClient([
                    'keyFilePath' => storage_path('app/administrator@aengzi.json')
                ]);
                $bucket = $storage->bucket($bucketName);
                $bucket->upload($m3u8String, [
                    'name' => 'vods/'.$clipVod->getKey().'/file.m3u8',
                    'metadata' => [
                        'started_at' => $files->first()->started_at,
                        'ended_at'   => $files->last()->ended_at
                    ]
                ]);

                if ( $clipVod->related_type == 'temp' )
                {
                    return;
                }

                $prefix = storage_path('temp/'.Str::random(32).'/');
                $tsData = shell_exec('curl "'.$files->first()->url.'"');
                exec('mkdir -p '.$prefix);
                file_put_contents($prefix.'video.ts', $tsData);
                exec('ffmpeg -i '.$prefix.'video.ts -ss 00:00:00.000 -vframes 1 -q:v 1 '.$prefix.'origin.jpg -nostats -loglevel 0 -y');
                $bucket->upload(fopen($prefix.'origin.jpg', 'r'), [
                    'name' => 'vods/'.$clipVod->getKey().'/origin.jpg'
                ]);
                exec('rm -rf '.$prefix);
            }],

            'clip_vod.result' => ['clip_vod', 'result', function ($clipVod, $result) {

                $result->setRelation('vod', $clipVod);
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'diff_timestamp' => ['started_at', 'ended_at', function ($startedAt, $endedAt) {

                $time      = 0;
                $endTime   = new \DateTime($endedAt);
                $startTime = new \DateTime($startedAt);
                $interval  = $startTime->diff($endTime);
                $time      = $time + $interval->d * 60 * 60 * 24;
                $time      = $time + $interval->h * 60 * 60;
                $time      = $time + $interval->i * 60;
                $time      = $time + $interval->s;
                $time      = $time + $interval->f;

                return $time;
            }],

            'duration' => ['files', function ($files) {

                $endTime   = new \DateTime($files->first()->started_at);
                $startTime = new \DateTime($files->last()->ended_at);
                $interval  = $startTime->diff($endTime);
                $time      = 0;
                $time      = $time + $interval->d * 60 * 60 * 24;
                $time      = $time + $interval->h * 60 * 60;
                $time      = $time + $interval->i * 60;
                $time      = $time + $interval->s;
                $time      = $time + $interval->f;

                return $time;
            }],

            'files' => ['started_at', 'ended_at', function ($startedAt, $endedAt) {

                return AftvFile::query()
                    ->where('started_at', '<=', $endedAt)
                    ->where('ended_at', '>=', $startedAt)
                    ->orderBy('started_at', 'asc')
                    ->get();
            }],

            'm3u8_string' => ['files', function($files) {

                $rtn = '#EXTM3U'.PHP_EOL.'#EXT-X-TARGETDURATION:6'.PHP_EOL.'#EXT-X-ALLOW-CACHE:YES'.PHP_EOL.'#EXT-X-PLAYLIST-TYPE:VOD'.PHP_EOL.'#EXT-X-VERSION:3'.PHP_EOL.'#EXT-X-MEDIA-SEQUENCE:1'.PHP_EOL;

                for ( $i = 0; $i < $files->count(); $i++ )
                {
                    $file = $files->get($i);
                    $rtn.='#EXTINF:'.$file->duration.','.PHP_EOL.$file->url.PHP_EOL;
                }

                $rtn.='#EXT-X-ENDLIST';

                return $rtn;
            }],

            'vod' => ['vod_id', function ($vodId) {

                return Vod::find($vodId);
            }],

            'vod_ended_at' => ['vod', function ($vod) {

                return $vod->ended_at;
            }],

            'vod_started_at' => ['vod', function ($vod) {

                return $vod->started_at;
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'files'
                => ['diff_timestamp:valid_all']
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'diff_timestamp'
                => ['integer', 'min:15', 'max:300'],

            'ended_at'
                => ['required', 'string', 'date_format:Y-m-d H:i:s', 'after_or_equal:{{vod_started_at}}'],

            'started_at'
                => ['required', 'string', 'date_format:Y-m-d H:i:s', 'before_or_equal:{{vod_ended_at}}'],

            'vod'
                => ['not_null'],

            'vod_id'
                => ['required', 'integer'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
