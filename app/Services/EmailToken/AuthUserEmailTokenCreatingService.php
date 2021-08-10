<?php

namespace App\Services\EmailToken;

use App\Services\Auth\AuthUserFindingService;
use Carbon\Carbon;
use FunctionalCoding\Service;
use Illuminate\Support\Str;

class AuthUserEmailTokenCreatingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'auth_user' => function ($token) {
                return [AuthUserFindingService::class, [
                    'token' => $token,
                ], [
                    'token' => '{{token}}',
                ]];
            },

            'body' => function ($payload) {
                return '
                    <p>
                        이메일 검증 페이지에서 아래 문자열을 입력해주세요
                    </p>
                    <p>
                        '.$payload['code'].'
                    </p>
                ';
            },

            'payload' => function ($authUser, $email) {
                return [
                    'code' => Str::random(6),
                    'email' => $email,
                    'expired_at' => Carbon::now('UTC')->addSeconds(300)->format('Y-m-d H:i:s'),
                    'uid' => $authUser->getKey(),
                ];
            },

            'subject' => function () {
                return '이메일 계정 소유자 확인 - aengzi.com';
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'token' => ['required'],

            'email' => ['required', 'string', 'email'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            EmailTokenCreatingService::class,
        ];
    }
}
