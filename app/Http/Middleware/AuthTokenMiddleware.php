<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jose\Component\Signature\Serializer\CompactSerializer;

class AuthTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $authorization = $request->header('Authorization');

        if ( is_string($authorization) )
        {
            $segs = preg_split('/^Bearer /', $authorization);

            if ( count($segs) == 2 && ! $request->offsetExists('token') )
            {
                $request->offsetSet('token', $segs[1]);
            }
        }

        return $next($request);
    }
}
