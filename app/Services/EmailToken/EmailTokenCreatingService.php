<?php

namespace App\Services\EmailToken;

use Carbon\Carbon;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use FunctionalCoding\Service;
use Illuminate\Extend\Service\GoogleClientService;
use Illuminate\Extend\Service\Token\TokenEncryptionService;
use Swift_Message;

class EmailTokenCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'attempt_count'
                => 'attempt count in 5 minutes',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'body.google_client' => function ($body, $email, $googleClient, $subject) {

                $msg = (new Swift_Message)
                        ->setTo([$email])
                        ->setSubject($subject)
                        ->setContentType('text/html')
                        ->setBody($body);

                $service = new Google_Service_Gmail($googleClient);
                $message = new Google_Service_Gmail_Message;
                $message->setId($email);
                $message->setRaw(base64_encode($msg));
                $service->users_messages->send('aengzi@llit.kr', $message);
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'attempt_count' => function ($email, $googleClient) {

                $service   = new Google_Service_Gmail($googleClient);
                $timestamp = Carbon::now('UTC')->subSeconds(300)->timestamp;
                $list      = $service->users_messages->listUsersMessages('aengzi@llit.kr', [
                    'q' => 'in:sent to:'.$email.' after:'.$timestamp
                ]);

                return count($list);
            },

            'google_client' => function () {

                $model      = GoogleClient::where('user', 'aengzi')->first();
                $token      = json_decode($model->access_token, true);
                $credential = json_decode($model->credential, true);

                return [GoogleClientService::class, [
                    'token'      => $token,
                    'credential' => $credential,
                ]];
            },

            'result' => function ($payload) {

                return [TokenEncryptionService::class, [
                    'payload'
                        => $payload
                ]];
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'body'
                => ['attempt_count:strict'],
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'attempt_count'
                => ['integer', 'lt:5'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
