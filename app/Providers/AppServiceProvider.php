<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        putenv('APP_VERSION=2.1.0');
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.base_path(env('GCP_SERVICE_ACCOUNT')));
    }
}
