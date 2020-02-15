<?php

namespace App\Services\PwdReset;

use App\Service;
use App\Models\PwdReset;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PwdResetUpdatingService extends Service {

    public static function getArrBindNames()
    {
        return [
            'result'
                => 'password reset for {{id}}',

            'result_complete'
                => 'completion of {{result}}',

            'result_token'
                => 'token of {{result}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'user.password' => ['user', 'password', function ($user, $newPassword) {

                $user->password = $newPassword;
                $user->save();
            }],

            'result_complete' => ['result', function ($result) {

                $result->complete = true;
                $result->save();
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => ['id', function ($id) {

                return PwdReset::find($id);
            }],

            'result_token' => ['result', function ($result) {

                return $result->token;
            }],

            'result_complete' => ['result', function ($result) {

                return $result->complete;
            }],

            'user' => ['result', function ($result) {

                return User::query()
                    ->where('email', $result->email)
                    ->first();
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

            'password'
                => ['required', 'string'],

            'result'
                => ['not_null'],

            'result_token'
                => ['same:{{token}}'],

            'result_complete'
                => ['false'],

            'token'
                => ['required', 'string']
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
