<?php

namespace App\Services\PwdReset;

use App\Service;
use App\Models\PwdReset;
use App\Models\User;
use App\Services\CreatingService;

class PwdResetCreatingService extends Service {

    public static function getArrBindNames()
    {
        return [
            'user'
                => 'user for {{email}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result.email' => ['result', 'email', function ($result, $email) {

                $confirmUrl = 'http://chrome-extension.aengzi.com/main/index.html#/password-reset?'.http_build_query([
                    'id'    => $result->getKey(),
                    'token' => $result->token
                ]);

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
                    'template_id' => 'd-730412dfde4a4fbcb1411e4a827c4ba7'
                ];

                exec('curl -X "POST" "https://api.sendgrid.com/v3/mail/send" -H \'Authorization: Bearer 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\' -H \'Content-Type: application/json\' -d \''.json_encode($data).'\'');
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'user' => ['email', function ($email) {

                return User::query()
                    ->where('email', $email)
                    ->first();
            }],

            'result' => ['user', function ($user) {

                return PwdReset::create([
                    'token'    => str_random(32),
                    'email'    => $user->email,
                    'complete' => false
                ]);
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
            'email'
                => ['required', 'email'],

            'user'
                => ['not_null']
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }

}
