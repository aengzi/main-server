<?php

namespace App\Services;

use App\Models\GoogleClient;
use App\Service;
use Carbon\Carbon;
use Google_Client;

class GoogleClientService extends Service
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
            'google_client' => [function () {

                $model      = GoogleClient::where('user', 'aengzi')->first();
                $token      = json_decode($model->access_token, true);
                $credential = json_decode($model->credential, true);
                $client     = new Google_Client();
                $created    = (int) $token['created'];
                $expiresIn  = (int) $token['expires_in'];
                $now        = (int) Carbon::now('UTC')->timestamp;

                $client->setAccessToken($token);
                $client->setAuthConfig($credential);

                if ( $now > $created + $expiresIn - 60 )
                {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    $model->access_token = json_encode($client->getAccessToken());
                    $model->save();
                }

                return $client;
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
