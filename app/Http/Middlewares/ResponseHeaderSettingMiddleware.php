<?php

namespace App\Http\Middlewares;

class ResponseHeaderSettingMiddleware
{
    public function handle($request, $next)
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Access-Control-Allow-Origin: '.preg_replace('/\/$/', '', $_SERVER['HTTP_REFERER']));
        }
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Accept, Authorization, Content-Type, Origin, X-Requested-With');
        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS');

        return $next($request);
    }
}
