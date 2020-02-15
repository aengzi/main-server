<?php

namespace App\Http;

use App\Service;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;

class Controller extends BaseController
{
    public static function input($key)
    {
        $args = func_get_args();

        if ( count($args) == 1 )
        {
            $args[1] = new \stdClass;
        }

        return Input::get($key, $args[1]);
    }

    public static function servicify($arr)
    {
        $arr   = array_add($arr, 1, []);
        $arr   = array_add($arr, 2, []);
        $class = $arr[0];
        $data  = $arr[1];
        $names = $arr[2];

        foreach ( $data as $key => $value )
        {
            $data[$key] = $value;

            if ( $value instanceof \stdClass)
            {
                unset($data[$key]);
            }
        }

        return inst($class, [$data, $names]);
    }
}
