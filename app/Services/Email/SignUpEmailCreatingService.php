<?php

namespace App\Services\Email;

use App\Service;
use App\Models\User;
use App\Services\TokenEncryptingService;

class SignUpEmailCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'same_email_user'
                => 'same email user',

            'same_nick_user'
                => 'same nickname user'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result.email' => ['result', 'email', function ($result, $email) {

                $confirmUrl = 'http://chrome-extension.aengzi.com/main/index.html#/sign-up-complete?token='.$result;

                $data = [
                    'from' => [
                        'email' => 'no-reply@aengzi.com',
                    ],
                    'personalizations' => [[
                        'to' => [[
                            'email' => $email
                        ]],
                        'dynamic_template_data' => [
                            'comfirm_url' => $confirmUrl
                        ]
                    ]],
                    'template_id' => 'd-b460ebcff7a14361ad8c86bb8464dbb2'
                ];

                exec('curl -X "POST" "https://api.sendgrid.com/v3/mail/send" -H \'Authorization: Bearer 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\' -H \'Content-Type: application/json\' -d \''.json_encode($data).'\'');
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'payload' => ['email', 'password', 'nick', function ($email, $password, $nick) {

                return [
                    'email'    => $email,
                    'password' => $password,
                    'nick'     => $nick
                ];
            }],

            'same_email_user' => ['email', function ($email) {

                return User::where('email', $email)->first();
            }],

            'same_nick_user' => ['nick', function ($nick) {

                return User::where('nick', $nick)->first();
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'result'
                => ['same_email_user', 'same_nick_user']
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'email'
                => ['required', 'string', 'email'],

            'password'
                => ['required', 'string', 'min:8', 'max:32'],

            'nick'
                => ['required', 'string', 'min:2', 'max:12'],

            'same_email_user'
                => ['null'],

            'same_nick_user'
                => ['null']
        ];
    }

    public static function getArrTraits()
    {
        return [
            TokenEncryptingService::class
        ];
    }
}
