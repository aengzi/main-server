<?php

namespace App\Services\Clip;

use App\Models\Clip;
use App\Services\Auth\AuthUserRequiringService;
use FunctionalCoding\Service;
use Google\Cloud\Storage\StorageClient;

class ClipDeletingService extends Service
{
    public static function getBindNames()
    {
        return [
            'clip' => 'clip for {{id}}',

            'user_id' => 'user_id of {{clip}}',
        ];
    }

    public static function getCallbackLists()
    {
        return [
            'result' => function ($authUser, $clip) {
                $clip->vod->data = null;
                $clip->vod->save();
                $clip->delete();

                $storage = new StorageClient([
                    'keyFilePath' => storage_path('app/administrator@aengzi.json'),
                ]);
                $bucket = $storage->bucket('aengzi.com');
                $objects = $bucket->objects([
                    'prefix' => 'vods/'.$clip->vod->getKey(),
                    'fields' => 'items/name',
                ]);

                foreach ($objects as $object) {
                    $object->delete();
                }
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'clip' => function ($id) {
                return Clip::find($id);
            },

            'result' => function () {
                return null;
            },

            'user_id' => function ($clip) {
                return $clip->user_id;
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
            'id' => ['required', 'integer'],

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
