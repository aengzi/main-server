<?php

namespace App\Http\Middlewares;

class ResponseHeaderSettingMiddleware
{
    public function handle($request, $next)
    {
        // header should be set before $next($request)
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Access-Control-Allow-Origin: '.preg_replace('/\/$/', '', $_SERVER['HTTP_REFERER']));
        }
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Accept, Authorization, Content-Type, Origin, X-Requested-With');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS');

        $response = $next($request);

        return $response;
    }
}
