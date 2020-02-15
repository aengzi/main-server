<?php

namespace App\Services\Clip;

use App\Service;
use App\Models\Clip;
use App\Models\CommentReply;
use App\Services\AuthUserRequiringService;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\DB;

class ClipDeletingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'clip'
                => 'clip for {{id}}',

            'user_id'
                => 'user_id of {{clip}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => ['auth_user', 'clip', function ($authUser, $clip) {

                $clip->vod->data = null;
                $clip->vod->save();
                $clip->delete();

                $storage = new StorageClient([
                    'keyFilePath' => storage_path('app/administrator@aengzi.json')
                ]);
                $bucket  = $storage->bucket('aengzi.com');
                $objects = $bucket->objects([
                    'prefix'
                        => 'vods/'.$clip->vod->getKey(),
                    'fields'
                        => 'items/name'
                ]);

                foreach ($objects as $object) {
                    $object->delete();
                }
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'clip' => ['id', function ($id) {

                return Clip::find($id);
            }],

            'user_id' => ['clip', function ($clip) {

                return $clip->user_id;
            }],

            'result' => [function () {

                return null;
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'id'
                => ['required', 'integer'],

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
