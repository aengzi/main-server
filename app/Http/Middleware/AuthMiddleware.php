<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jose\Component\Signature\Serializer\CompactSerializer;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if ( $request->header('Authorization') )
        {
            $token  = explode(' ', $request->header('Authorization'))[1];
            $jws    = (new CompactSerializer)->unserialize($token);
            $userId = json_decode($jws->getPayload(), true)['aud'];
            $user   = User::find($userId);

            Auth::setUser($user);
        }

        return $next($request);
    }
}
