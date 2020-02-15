<?php

namespace App\Http\Middleware;

class CrossOriginAllMiddleware {

    public function handle($request, $next)
    {
        $response = $next($request);

        $response->header('Access-Control-Allow-Origin', 'http://localhost:4200');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers','Accept, Authorization, Content-Type, DNT, Origin, Referer, User-Agent, X-XSRF-TOKEN, X-CSRF-TOKEN');
        $response->header('Access-Control-Allow-Credentials',' true');

        return $response;
    }

}
