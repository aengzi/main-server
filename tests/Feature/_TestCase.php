<?php

namespace Tests\Feature;

use App\Model;
use Faker\Generator as Faker;
use FunctionalCoding\JWT\Service\TokenEncryptionService;
use FunctionalCoding\ORM\Eloquent\Http\ServiceRunMiddleware;
use FunctionalCoding\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class _TestCase extends TestCase
{
    protected $data;

    protected $faker;

    protected $inputs;

    protected $server;

    protected $service;

    protected $uri;

    protected $url;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = app(Faker::class);

        $this->withoutMiddleware(ServiceRunMiddleware::class);

        Service::setResponseErrorsResolver(function ($errors) {
            $msgs = [];
            \array_walk_recursive($errors, function ($value) use (&$msgs) {
                $msgs[] = $value;
            });

            return $msgs;
        });

        app('db')->beginTransaction();
    }

    public function tearDown(): void
    {
        $this->beforeApplicationDestroyed(function () {
            DB::disconnect();
        });

        app('db')->rollback();

        parent::tearDown();
    }

    public function assertError($error)
    {
        $errors = $this->service->getResponseErrors();

        $this->assertContains($error, $errors, implode(',', $errors));
    }

    public function assertNoError()
    {
        $errors = $this->service->getResponseErrors();

        $this->assertEquals($errors, []);
        $this->assertTrue($this->service->getData()->offsetExists('result'));
    }

    public function assertPersistence($model, $existCount = 1)
    {
        $attrs = $model->getAttributes();
        $query = app(get_class($model))->query();

        foreach ($attrs as $attr => $value) {
            $query->where($attr, $value);
        }

        $this->assertEquals($existCount, $query->count());
    }

    public function assertResult($expect)
    {
        $errors = $this->service->getResponseErrors();
        $this->assertEquals([], $errors, implode(',', $errors));

        $result = $this->service->getData()->getArrayCopy()['result'];

        $this->assertEquals($expect, $result);
    }

    public function assertResultWithFinding($expectId)
    {
        $errors = $this->service->getResponseErrors();
        $this->assertEquals([], $errors, implode(',', $errors));

        $result = $this->service->getData()->getArrayCopy()['result'];

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($expectId, $result->getKey());
    }

    public function assertResultWithListing($expectIds)
    {
        $errors = $this->service->getResponseErrors();
        $this->assertEquals([], $errors, implode(',', $errors));

        $result = $this->service->getData()->getArrayCopy()['result'];

        foreach ($expectIds as $expectId) {
            $this->assertContains($expectId, $result->modelKeys());
        }

        $this->assertEquals(
            count($result->modelKeys()),
            count($expectIds),
            'result:'.implode(',', $result->modelKeys()).',expect:'.implode(',', $expectIds)
        );
    }

    public function assertResultWithPaging($expectIds)
    {
        $errors = $this->service->getResponseErrors();
        $this->assertEquals([], $errors, implode(',', $errors));

        $result = $this->service->getData()->getArrayCopy()['result']->modelKeys();

        sort($expectIds);
        sort($result);

        $this->assertEquals($result, $expectIds);
    }

    public function assertResultWithPersisting($expects)
    {
        $errors = $this->service->getResponseErrors();
        $this->assertEquals([], $errors, implode(',', $errors));

        $result = $this->service->getData()->getArrayCopy()['result'];
        if ($expects instanceof Model) {
            $this->assertInstanceOf(Model::class, $result);

            $expects = collect([$expects]);
            $result = collect([$result]);
        }

        foreach ($result as $i => $model) {
            $expect = $expects[$i];

            $this->assertInstanceOf(Model::class, $model);
            $this->assertEquals(get_class($expect), get_class($model));
            $this->assertEquals([], array_diff($expect->toArray(), $model->toArray()));
        }
    }

    public function getResponse()
    {
        $class = explode('\\', static::class);
        $class = array_pop($class);
        $class = Str::snake($class);
        $class = preg_replace('/_test$/', '', $class);
        $class = explode('_', $class);
        $method = strtoupper(array_pop($class));

        return $this->call($method, $url = $this->url, $parameters = $this->inputs, $cookies = [], $files = [], $server = $this->server, $content = null);
    }

    public function runService()
    {
        $response = $this->getResponse();
        $content = $response->getOriginalContent();

        $this->assertTrue(Service::isInitable($content), json_encode($content).' is not initable service.');

        $service = Service::initService($content);
        $service->run();

        $this->service = $service;
        $this->data = $service->getData()->getArrayCopy();

        return $service;
    }

    public function setAuthUser($user)
    {
        $service = new TokenEncryptionService([
            'payload' => [
                'uid' => $user->getKey(),
                'expired_at' => '9999-12-31 23:59:59',
            ],
            'public_key' => \file_get_contents(storage_path('app/id_rsa.pub')),
        ], [
            'payload' => '...',
            'public_key' => '...',
        ]);
        $this->server['HTTP_AUTHORIZATION'] = 'Bearer '.$service->run();
    }

    public function setInputParameter($key, $value)
    {
        $this->inputs[$key] = $value;
    }

    public function setRouteParameter($key, $value)
    {
        $replace = $value;
        $subject = $this->url;
        $search = '{'.$key.'}';

        $this->url = str_replace($search, $replace, $subject);
    }

    public function when()
    {
        $this->url = $this->uri;
        $this->inputs = [];
        $this->server = [];

        app('db')->beginTransaction();

        call_user_func(func_get_args()[0]);

        app('db')->rollback();

        $this->createApplication(); // reset global state
    }

    public function withoutMiddleware($middleware = null)
    {
        if (is_null($middleware)) {
            $this->app->instance('middleware.disable', true);

            return $this;
        }

        foreach ((array) $middleware as $abstract) {
            $this->app->instance($abstract, new class() {
                public function handle($request, $next)
                {
                    return $next($request);
                }
            });
        }

        return $this;
    }
}
