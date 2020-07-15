<?php

namespace App\Services\Clip;

use App\Service;
use App\Models\AftvFile;
use App\Models\AftvM3u8;
use App\Models\Vod;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Str;

class ClipCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'diff_sec'
                => 'second between {{start_sec}} and {{end_sec}}',

            'vod'
                => 'vod for {{vod_id}}',

            'vod_duration'
                => 'duration of {{vod}}',
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
                    'keyFilePath' => storage_path('app'.DIRECTORY_SEPARATOR.'administrator@aengzi.json')
                ]);
                $bucket = $storage->bucket($bucketName);
                $bucket->upload($m3u8String, [
                    'name' => 'vods/'.$clipVod->getKey().'/file.m3u8'
                ]);

                if ( $clipVod->related_type == 'temp' )
                {
                    return;
                }

                $prefix = storage_path(Str::random(32));
                $tsData = file_get_contents($files->first()->url);
                file_put_contents($prefix.'video.ts', $tsData);
                exec('ffmpeg -i '.$prefix.'video.ts -ss 00:00:00.000 -vframes 1 -q:v 1 '.$prefix.'origin.jpg -nostats -loglevel 0 -y');
                $bucket->upload(fopen($prefix.'origin.jpg', 'r'), [
                    'name' => 'vods/'.$clipVod->getKey().'/origin.jpg'
                ]);
                unlink($prefix.'video.ts');
                unlink($prefix.'origin.jpg');
            }],

            'clip_vod.result' => ['clip_vod', 'result', function ($clipVod, $result) {

                $result->setRelation('vod', $clipVod);
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'diff_sec' => ['start_sec', 'end_sec', function ($startSec, $endSec) {

                return $endSec - $startSec;
            }],

            'started_at' => ['vod', 'start_sec', function ($vod, $startSec) {

                $matches = [];
                preg_match_all('/\#EXTINF:(\d*\.\d*)/', $vod->data, $matches);
                $minSec  = 0;

                foreach ( $matches[1] as $i => $sec )
                {
                    $minSec += $sec;
                    if ( $minSec >= $startSec )
                    {
                        $index = $i;
                        break;
                    }
                }

                $matches    = [];
                preg_match_all('/http.+\.ts/', $vod->data, $matches);
                $url        = $matches[0][$index];
                $matches    = [];
                preg_match_all('/(\d{9})_(\d{1,})/', $url, $matches);
                $bcastId    = $matches[1][0];
                $m3u8Index  = $matches[2][0];
                $fM3u8      = AftvM3u8::where([
                    'bcast_id'   => $bcastId,
                    'm3u8_index' => $m3u8Index
                ])->first();
                $matches    = [];
                preg_match_all('/'.str_replace('###', '(\d+)', $fM3u8->file_prefix).'/', $url, $matches);
                $fileIndex  = $matches[1][0];

                return AftvFile::where([
                    'bcast_id'   => $bcastId,
                    'm3u8_index' => $m3u8Index,
                    'file_index' => $fileIndex
                ])->first()->started_at;
            }],

            'ended_at' => ['vod', 'end_sec', function ($vod, $endSec) {

                $matches = [];
                preg_match_all('/\#EXTINF:(\d*\.\d*)/', $vod->data, $matches);
                $minSec  = 0;

                foreach ( $matches[1] as $i => $sec )
                {
                    $minSec += $sec;
                    if ( $minSec >= $endSec )
                    {
                        $index = $i;
                        break;
                    }
                }

                $matches    = [];
                preg_match_all('/http.+\.ts/', $vod->data, $matches);
                $url        = $matches[0][$index];
                $matches    = [];
                preg_match_all('/(\d{9})_(\d{1,})/', $url, $matches);
                $bcastId    = $matches[1][0];
                $m3u8Index  = $matches[2][0];
                $fM3u8      = AftvM3u8::where([
                    'bcast_id'   => $bcastId,
                    'm3u8_index' => $m3u8Index
                ])->first();
                $matches    = [];
                preg_match_all('/'.str_replace('###', '(\d+)', $fM3u8->file_prefix).'/', $url, $matches);
                $fileIndex  = $matches[1][0];

                return AftvFile::where([
                    'bcast_id'   => $bcastId,
                    'm3u8_index' => $m3u8Index,
                    'file_index' => $fileIndex
                ])->first()->ended_at;
            }],

            'files' => ['vod', 'started_at', 'ended_at', function ($vod, $startedAt, $endedAt) {

                return AftvFile::query()
                    ->where('bcast_id', $vod->bcast_id)
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

            'vod_duration' => ['vod', function ($vod) {

                return $vod->sum('duration');
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'files'
                => ['diff_sec:valid_all']
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'diff_sec'
                => ['integer', 'min:15', 'max:300'],

            'end_sec'
                => ['required', 'integer', 'gt:{{start_sec}}', 'lte:{{vod_duration}}'],

            'start_sec'
                => ['required', 'integer', 'gt:0'],

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
