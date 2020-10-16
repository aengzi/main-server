<?php

use Illuminate\Extend\Http\ServiceRunMiddleware;
use Illuminate\Extend\Service;

abstract class FunctionalTest extends TestCase
{
    public $uri;
    public $environment = 'functional';
    public $input = [];
    public $server = [];
    public $url;

    public function assertResult($expect)
    {
        $serv   = $this->runService();
        $result = $serv->data()->get('result');
        $errors = $serv->totalErrors()->all();

        $this->assertEquals([], $errors, implode(',', $errors));
        $this->assertEquals($expect, $result);
    }

    public function assertPersistence($model, $existCount = 1)
    {
        $attrs = $model->getAttributes();
        $query = $model->query();

        foreach ( $attrs as $attr => $value )
        {
            $query->where($attr, $value);
        }

        $this->assertEquals($existCount, $query->count());
    }

    public function assertDeletion($model)
    {
        $this->assertPersistence($model, 0);
    }

    public function assertError($msg)
    {
        $serv   = $this->runService();
        $errors = $serv->totalErrors()->all();

        $this->assertContains($msg, $errors, implode(',', $errors));
    }

    public function assertResultWithPersisting($expects)
    {
        $serv   = $this->runService();
        $result = $serv->data()->get('result');
        $errors = $serv->totalErrors()->all();

        if ( $expects instanceof Model )
        {
            $this->assertInstanceOf(Model::class, $result);

            $expects = collect([$expects]);
            $result  = collect([$result]);
        }

        $this->assertEquals([], $errors, implode(',', $errors));
        $this->assertEquals(get_class($expects), get_class($result));

        foreach ( $result as $i => $model )
        {
            $expect = $expects[$i];

            $this->assertInstanceOf(Model::class, $model);
            $this->assertEquals(get_class($expect), get_class($model));
            $this->assertEquals([], array_diff($expect->toArray(), $model->toArray()));
        }
    }

    public function assertResultWithFinding($expectId)
    {
        $serv   = $this->runService();
        $result = $serv->data()->get('result');
        $errors = $serv->totalErrors()->all();

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($expectId, $result->getKey());
    }

    public function assertResultWithListing($expectIds)
    {
        $serv   = $this->runService();
        $result = $serv->data()->get('result');
        $errors = $serv->totalErrors()->all();

        $this->assertEquals([], $errors, implode(',', $errors));

        foreach ( $expectIds as $expectId )
        {
            $this->assertContains($expectId, $result->modelKeys());
        }
    }

    public function assertResultWithPaging($expectIds)
    {
        $serv    = $this->runService();
        $result  = $serv->data()->get('result')->modelKeys();
        $errors  = $serv->totalErrors()->all();

        sort($expectIds);
        sort($result);

        $this->assertEquals([], $errors, implode(',', $errors));
        $this->assertEquals($result, $expectIds);
    }

    public function assertResultWithReturning($expect)
    {
        $serv    = $this->runService();
        $result  = $serv->data()->get('result');
        $errors  = $serv->totalErrors()->all();

        $this->assertEquals([], $errors, implode(',', $errors));
        $this->assertEquals($expect, $result);
    }

    public function runService()
    {
        $this->app->instance(ServiceRunMiddleware::class, new class
        {
            public function handle($request, $next)
            {
                return $next($request);
            }
        });

        $method     = explode('\\', static::class);
        $method     = array_pop($method);
        $method     = snake_case($method);
        $method     = preg_replace('/_test$/', '', $method);
        $method     = explode('_', $method);
        $method     = strtoupper(array_pop($method));
        $response   = $this->call($method, $url = $this->url, $parameters = $this->input, $cookies = [], $files = [], $server = $this->server, $content = null);
        $content    = $response->getOriginalContent();
        $isInitable = Service::isInitable($content);

        $this->assertTrue($isInitable);

        $service = Service::initService($content);
        $service->run();

        return $service;
    }

    public function setAuthUser($user)
    {
        auth()->setUser($user);
    }

    public function setInputParameter($key, $value)
    {
        $this->input[$key] = $value;
    }

    public function setRouteParameter($key, $value)
    {
        $replace = $value;
        $subject = $this->url;
        $search  = '{'.$key.'}';

        $this->url = str_replace($search, $replace, $subject);
    }

    public function setServerParameter($key, $value)
    {
        $this->server[$key] = $value;
    }

    public function when()
    {
        $args = func_get_args();

        $this->url = $this->uri;
        $this->input = [];

        app('db')->beginTransaction();

        call_user_func($args[0]);

        app('db')->rollback();
    }
}
