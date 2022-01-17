<?php

namespace App\Services\Email;

use FunctionalCoding\Service;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class EmailCreatingService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'result' => function ($body, $email, $subject) {
                $transport = (new Swift_SmtpTransport(
                    env('SMTP_HOST'),
                    env('SMTP_PORT'),
                    env('SMTP_ENCRYPTION')
                ))
                    ->setUsername(env('SMTP_USERNAME'))
                    ->setPassword(env('SMTP_PASSWORD'))
                ;
                $mailer = new Swift_Mailer($transport);
                $message = (new Swift_Message($subject))
                    ->setFrom(['admin@aengzi.com'])
                    ->setTo([$email])
                    ->setContentType('text/html')
                    ->setBody($body)
                ;

                return $mailer->send($message);
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
            'body' => ['required', 'string'],

            'email' => ['required', 'string', 'email'],

            'subject' => ['required', 'string'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
