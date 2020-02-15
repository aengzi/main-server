<?php

namespace App\Services\User;

use App\Service;
use App\Models\User;
use App\Services\AuthUserRequiringService;
use App\Services\TokenPayloadReturningService;
use Google\Cloud\Storage\StorageClient;

class UserUpdatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'email'
                => 'email in payload in {{token}}',

            'user'
                => 'user for {{id}}',

            'user_id'
                => '{{id}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'user.nick' => ['user', 'nick', function ($user, $nick) {

                $user->nick = $nick;
            }],

            'user.password' => ['user', 'password', function ($user, $password) {

                $user->password = $password;
            }],

            'user.thumbnail' => ['user', 'thumbnail', function ($user, $thumbnail) {

                $storage = new StorageClient([
                    'keyFilePath' => storage_path('app/administrator@aengzi.json')
                ]);
                $bucket = $storage->bucket('aengzi.com');
                $bucket->upload(base64_decode($thumbnail), [
                    'name' => 'users/'.$user->getKey().'/origin.jpg',
                ]);
                $user->has_thumbnail = true;
            }],

            'user.email' => ['user', 'email', function ($user, $email) {

                if ( $email )
                {
                    $user->email = $email;
                }
            }],

            'result' => ['result', function ($result) {

                $result->save();
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'email' => ['payload', function ($payload) {

                return array_key_exists('email', $payload) ? $payload['email'] : null;
            }],

            'result' => ['user', function ($user) {

                return $user;
            }],

            'same_nick_user' => ['nick', function ($nick) {

                return User::lockForUpdate()->where('nick', $nick)->first();
            }],

            'user' => ['user_id', function ($userId) {

                return User::find($userId);
            }],

            'user_id' => ['id', function ($id) {

                return (int)$id;
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

            'user'
                => ['not_null'],

            'user_id'
                => ['same:{{auth_user_id}}'],

            'nick'
                => ['string', 'min:2', 'max:12'],

            'password'
                => ['string', 'min:8', 'max:32'],

            'thumbnail'
                => ['string', 'base64_image', 'max:'.(4096*1024)],

            'email'
                => ['required_without_all:{{nick}},{{password}},{{thumbnail}}']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class
        ];
    }
}
