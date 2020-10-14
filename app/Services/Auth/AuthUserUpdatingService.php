<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Auth\AuthUserRequiringService;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Extend\Service;

class AuthUserUpdatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'email'
                => 'email in payload in {{token}}',

            'same_email_user'
                => 'same email user',

            'same_nick_user'
                => 'same nickname user',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'auth_user.email' => ['auth_user', 'email', function ($authUser, $email) {

                if ( !empty($email) )
                {
                    $authUser->email = $email;
                }
            }],

            'auth_user.nick' => ['auth_user', 'nick', function ($authUser, $nick) {

                $authUser->nick = $nick;
            }],

            'auth_user.password' => ['auth_user', 'password', function ($authUser, $password) {

                $authUser->password = $password;
            }],

            'auth_user.thumbnail' => ['auth_user', 'thumbnail', function ($authUser, $thumbnail) {

                $storage = new StorageClient([
                    'keyFilePath' => storage_path('app/administrator@aengzi.json')
                ]);
                $bucket = $storage->bucket('aengzi.com');
                $bucket->upload(base64_decode($thumbnail), [
                    'name' => 'users/'.$authUser->getKey().'/origin.jpg',
                    'metadata' => [
                        'Cache-Control' => 'no-cache',
                        'max-age' => '0',
                    ],
                ]);
                $authUser->has_thumbnail = true;
            }],

            'result' => ['result', function ($result) {

                $result->save();
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'email' => ['payload', function ($payload) {

                return isset($payload['email']) ? $payload['email'] : null;
            }],

            'result' => ['auth_user', function ($authUser) {

                return $authUser;
            }],

            'same_email_user' => ['email', function ($email) {

                if ( !empty($email) )
                {
                    return User::lockForUpdate()->where('email', $email)->first();
                }
            }],

            'same_nick_user' => ['nick', function ($nick) {

                return User::lockForUpdate()->where('nick', $nick)->first();
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'result'
                => ['same_email_user:strict', 'same_nick_user:strict'],
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'nick'
                => ['string', 'min:2', 'max:12'],

            'password'
                => ['string', 'min:8', 'max:32'],

            'thumbnail'
                => ['string', 'base64_image', 'max:'.(4096*1024)],

            'same_email_user'
                => ['null'],

            'same_nick_user'
                => ['null'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class,
        ];
    }
}
