<?php

namespace App\Http\Middlewares;

class RequestInputValueCastingMiddleware
{
    public function handle($request, $next)
    {
        foreach ($request->all() as $key => $value) {
            if (null === $value) {
                $value = '';
            } elseif ('null' === $value) {
                $value = null;
            } elseif ('false' === $value) {
                $value = false;
            } elseif ('true' === $value) {
                $value = true;
            } elseif (is_numeric($value)) {
                $value = $value * 1;
            }

            $request->offsetSet($key, $value);
        }

        return $next($request);
    }
}
