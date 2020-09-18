<?php

require_once __DIR__.'/../vendor/autoload.php';

if ( ! function_exists('inst') )
{
    function inst($class, $args = [])
    {
        $ref     = new ReflectionClass($class);
        $cons    = $ref->getConstructor();
        $params  = $cons ? $cons->getParameters(): [];
        $argsDic = [];

        foreach ( $params as $i => $param )
        {
            if ( array_key_exists($i, $args) )
            {
                $argsDic[$param->getName()] = $args[$i];
            }
        }

        return app($class, $argsDic);
    }
}

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__),
    getenv('APP_ENV') ? '.env.'.getenv('APP_ENV') : '.env.production'
))->bootstrap();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();
$app->withEloquent();

if ( array_key_exists('GAE_ENV', $_SERVER) )
{
    $app->useStoragePath(env('APP_STORAGE', base_path() . '/storage'));
}

config([
    'database.connections.mysql.options' => [
        PDO::MYSQL_ATTR_SSL_CA   => storage_path('app/database/server-ca.pem'),
        PDO::MYSQL_ATTR_SSL_CERT => storage_path('app/database/client-cert.pem'),
        PDO::MYSQL_ATTR_SSL_KEY  => storage_path('app/database/client-key.pem'),
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
    ]
]);

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\ModelMorphMapServiceProvider::class);
$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
