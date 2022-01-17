<?php

namespace App\Services\EmailToken;

use App\Models\User;
use Carbon\Carbon;
use FunctionalCoding\Service;
use Illuminate\Support\Str;

class PasswordResetEmailTokenCreatingService extends Service
{
    public static function getBindNames()
    {
        return [
            'same_email_user' => 'same email user for {{email}}',
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
                        이메일 검증 페이지에서 아래 문자열을 입력해주세요
                    </p>
                    <p>
                        '.$payload['code'].'
                    </p>
                ';
            },

            'payload' => function ($sameEmailUser) {
                return [
                    'code' => Str::random(6),
                    'expired_at' => Carbon::now('UTC')->addSeconds(300)->format('Y-m-d H:i:s'),
                    'uid' => $sameEmailUser->getKey(),
                ];
            },

            'same_email_user' => function ($email) {
                return User::lockForUpdate()->where('email', $email)->first();
            },

            'subject' => function () {
                return '이메일 계정 소유자 확인 - aengzi.com';
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
            'same_email_user' => ['required', 'not_null'],
        ];
    }

    public static function getTraits()
    {
        return [
            EmailTokenCreatingService::class,
        ];
    }
}
