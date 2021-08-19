<?php

namespace App\Http;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

class Controller extends \Laravel\Lumen\Routing\Controller
{
    public static function bearerToken()
    {
        return Request::bearerToken() ? Request::bearerToken() : '';
    }

    public static function input($key)
    {
        return Arr::get(Request::all(), $key, '');
    }

    public static function route($key)
    {
        return Request::route($key);
    }
}
