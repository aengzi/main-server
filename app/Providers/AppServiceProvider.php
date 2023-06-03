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
        $this->app['auth']->viaRequest('api', function () {});
        putenv('APP_VERSION=2.1.0');
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.storage_path(implode(DIRECTORY_SEPARATOR, ['app', 'gcp-credentials.json'])));
    }
}
