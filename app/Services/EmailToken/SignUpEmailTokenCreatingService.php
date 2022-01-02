<?php

namespace App\Services\EmailToken;

use App\Models\User;
use Carbon\Carbon;
use FunctionalCoding\Service;
use Illuminate\Support\Str;

class SignUpEmailTokenCreatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'same_email_user' => 'same email user',

            'same_nick_user' => 'same nickname user',
        ];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'body' => function ($payload) {
                return '
                    <p>
                        가입 이메일 검증 페이지에서 아래 문자열을 입력해주세요.
                    </p>
                    <p>
                        '.$payload['code'].'
                    </p>
                ';
            },

            'payload' => function ($email, $nick, $password) {
                return [
                    'email' => $email,
                    'password' => $password,
                    'nick' => $nick,
                    'code' => Str::random(6),
                    'expired_at' => Carbon::now('UTC')->addSeconds(3600)->format('Y-m-d H:i:s'),
                ];
            },

            'same_email_user' => function ($email) {
                return User::lockForUpdate()->where('email', $email)->first();
            },

            'same_nick_user' => function ($nick) {
                return User::lockForUpdate()->where('nick', $nick)->first();
            },

            'subject' => function () {
                return '가입 이메일 확인 - aengzi.com';
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [
            'payload' => ['same_email_user', 'same_nick_user'],
        ];
    }

    public static function getRuleLists()
    {
        return [
            'email' => ['required', 'string', 'email'],

            'password' => ['required', 'string', 'min:8', 'max:32'],

            'nick' => ['required', 'string', 'min:2', 'max:12'],

            'same_email_user' => ['null'],

            'same_nick_user' => ['null'],
        ];
    }

    public static function getTraits()
    {
        return [
            EmailTokenCreatingService::class,
        ];
    }
}
