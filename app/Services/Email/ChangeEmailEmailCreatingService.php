<?php

namespace App\Services\Email;

use App\Service;
use App\Services\AuthUserRequiringService;
use App\Services\TokenEncryptingService;
use Illuminate\Support\Facades\Request;

class ChangeEmailEmailCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result.result_payload' => ['result', 'result_payload', function ($result, $resultPayload) {

                $email      = $resultPayload['email'];
                $uId        = $resultPayload['uid'];
                $confirmUrl = 'http://chrome-extension.aengzi.com/main/index.html#/email-change-complete?'.http_build_query([
                    'id'    => $uId,
                    'token' => $result
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
                    'template_id' => 'd-e866469cbdd844d393ba5632b7289c2b'
                ];

                exec('curl -X "POST" "https://api.sendgrid.com/v3/mail/send" -H \'Authorization: Bearer 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\' -H \'Content-Type: application/json\' -d \''.json_encode($data).'\'');
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => ['result_payload', function ($resultPayload) {

                return [TokenEncryptingService::class, [
                    'payload'
                        => $resultPayload
                ], [
                ]];
            }],

            'result_payload' => ['auth_user', 'email', function ($authUser, $email) {

                return [
                    'uid' => $authUser->getKey(),
                    'email' => $email
                ];
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
                => ['required', 'string', 'email']
        ];
    }

    public static function getArrTraits()
    {
        return [
            AuthUserRequiringService::class
        ];
    }
}
