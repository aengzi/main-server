<?php

use App\Service;
use App\Http\Controller;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\WithoutMiddleware;

abstract class FunctionalTest extends TestCase
{
    // use DatabaseMigrations;
    use WithoutMiddleware;

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
        $query = inst(get_class($model))->query();

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
        $class     = explode('\\', static::class);
        $class     = array_pop($class);
        $class     = snake_case($class);
        $class     = preg_replace('/_test$/', '', $class);
        $class     = explode('_', $class);
        $method    = strtoupper(array_pop($class));
        $response  = $this->call($method, $url = $this->url, $parameters = $this->input, $cookies = [], $files = [], $server = $this->server, $content = null);
        $content   = $response->getOriginalContent();
        $isService = is_array($content) && array_key_exists(0, $content) && is_string($content[0]) && preg_match('/Service$/', $content[0]);

        $this->assertTrue($isService);
        $service = Controller::servicify($content);
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
