<?php

namespace App\Providers;

use App\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator as Validation;

class ValidationProvider extends ServiceProvider
{
    public function register()
    {
        Validation::resolver(function ($translator, $data, $rules, $customMessages, $customNames) {
            return new Validator(
                $translator,
                $data,
                $rules,
                $customMessages,
                $customNames
            );
        });
    }
}
