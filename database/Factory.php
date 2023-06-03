<?php

namespace Database;

abstract class Factory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    public function modelNameResolver(): \Closure
    {
        return function (Factory $factory) {
            return str_replace(
                'Database\\Factories',
                'App\\Models',
                get_class($factory)
            );
        };
    }
}
