<?php

namespace App\Services\EmailToken;

use FunctionalCoding\JWT\Service\TokenEncryptionService;
use FunctionalCoding\Service;
use Google\Cloud\Tasks\V2\AppEngineHttpRequest;
use Google\Cloud\Tasks\V2\AppEngineRouting;
use Google\Cloud\Tasks\V2\CloudTasksClient;
use Google\Cloud\Tasks\V2\HttpMethod;
use Google\Cloud\Tasks\V2\Task;
use Illuminate\Support\Facades\File;

class EmailTokenCreatingService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'result.email:after_commit' => function ($body, $email, $subject) {
                $routing = new AppEngineRouting();
                $routing->setService('api');
                $routing->setVersion(env('APP_VERSION'));

                $httpRequest = new AppEngineHttpRequest();
                $httpRequest->setRelativeUri('/emails');
                $httpRequest->setHttpMethod(HttpMethod::POST);
                $httpRequest->setBody(json_encode([
                    'email' => $email,
                    'subject' => $subject,
                    'body' => $body,
                ]));
                $httpRequest->setHeaders(['content-type' => 'application/json']);
                $httpRequest->setAppEngineRouting($routing);

                $task = new Task();
                $task->setAppEngineHttpRequest($httpRequest);

                $client = new CloudTasksClient();
                $queue = $client->queueName(
                    env('GCP_PROJECT_ID'),
                    env('GCP_LOCATION_ID'),
                    env('GCP_QUEUE_ID'),
                );

                $client->createTask($queue, $task);
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'body' => function () {
                throw new \Exception();
            },

            'payload' => function () {
                throw new \Exception();
            },

            'result' => function ($payload) {
                return [TokenEncryptionService::class, [
                    'payload' => $payload,
                    'public_key' => File::get(storage_path('app/id_rsa.pub')),
                ]];
            },

            'subject' => function () {
                throw new \Exception();
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
            'email' => ['required', 'string', 'email'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
