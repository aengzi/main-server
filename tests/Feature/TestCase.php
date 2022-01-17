<?php

namespace Tests\Feature;

use App\Http\ServiceRunMiddleware;
use FunctionalCoding\JWT\Service\TokenEncryptionService;
use FunctionalCoding\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

abstract class TestCase extends \Tests\TestCase
{
    public $input = [];
    public $server = [];
    public $uri;
    public $url;

    protected function setUp(): void
    {
        parent::setUp();

        $regExps = [
            '/Tests\\\Feature\\\(.*)Test$/' => '$1',
            '/Index$/' => ':get',
            '/Show$/' => '/{id}:get',
            '/Store$/' => ':post',
            '/Update$/' => ':patch',
            '/Destroy$/' => ':delete',
            '/\\\/' => '/',
        ];
        $str = preg_replace(
            array_keys($regExps),
            array_values($regExps),
            static::class
        );
        $str = Str::snake($str, '-');
        $str = str_replace('/-', '/', $str);

        $this->uri = preg_replace('/\/$/', '', explode(':', $str)[0]);
        $this->method = explode(':', $str)[1];
    }

    public function assertDeletion($model)
    {
        $this->assertPersistence($model, 0);
    }

    public function assertPersistence($model, $existCount = 1)
    {
        $attrs = $model->getAttributes();
        $query = $model->query();

        foreach ($attrs as $attr => $value) {
            $query->where($attr, $value);
        }

        $this->assertEquals($existCount, $query->count());
    }

    public function assertResult($expect)
    {
        $this->assertEquals([], $this->errors, implode(',', $this->errors));
        $this->assertEquals($expect, $this->result);
    }

    public function assertResultWithFinding($expectId)
    {
        $this->assertInstanceOf(Model::class, $this->result);
        $this->assertEquals($expectId, $this->result->getKey());
    }

    public function assertResultWithListing($expectIds)
    {
        $this->assertEquals([], $this->errors, implode(',', $this->errors));

        foreach ($expectIds as $expectId) {
            $this->assertContains($expectId, $this->result->modelKeys());
        }
    }

    public function assertResultWithPaging($expectIds)
    {
        $errors = $this->errors;
        $actualIds = $this->result->modelKeys();

        sort($expectIds);
        sort($actualIds);

        $this->assertEquals([], $errors, implode(',', $errors));
        $this->assertEquals($actualIds, $expectIds);
    }

    public function assertResultWithPersisting($expects)
    {
        $errors = $this->errors;
        $result = $this->result;

        if ($expects instanceof Model) {
            $this->assertInstanceOf(Model::class, $result);

            $expects = collect([$expects]);
            $result = collect([$result]);
        }

        $this->assertEquals([], $errors, implode(',', $errors));
        $this->assertEquals(get_class($expects), get_class($result));

        foreach ($result as $i => $model) {
            $expect = $expects[$i];

            $this->assertInstanceOf(Model::class, $model);
            $this->assertEquals(get_class($expect), get_class($model));
            $this->assertEquals([], array_diff($expect->toArray(), $model->toArray()));
        }
    }

    public function assertResultWithReturning($expect)
    {
        $this->assertEquals($expect, $this->result);
    }

    public function expectErrorMsg($msg, $func = null)
    {
        $this->runService();

        $this->assertContains($msg, $this->errors, implode(',', $this->errors));

        if ($func) {
            call_user_func($func);
        }

        DB::rollback();
    }

    public function expectSuccess($func = null)
    {
        $this->runService();

        $this->assertEquals([], $this->errors, implode(',', $this->errors));
        $this->assertTrue($this->data->offsetExists('result'));

        if ($func) {
            call_user_func($func);
        }

        DB::rollback();
    }

    public function runService()
    {
        $this->withoutMiddleware(ServiceRunMiddleware::class);

        $response = $this->call(
            $this->method,
            $this->url,
            $this->input,
            [], // cookies
            [], // files
            $this->server,
            null // content
        );

        $content = $response->getOriginalContent();
        $this->assertTrue(Service::isInitable($content));

        $service = Service::initService($content);
        $service->run();

        $this->errors = $service->getTotalErrors();
        $this->data = $service->getData();
        $this->result = $service->getData()->offsetGet('result');

        if (empty($this->errors)) {
            $service->runAfterCommitCallbacks();
        }

        return $service;
    }

    public function setAuthUser($user)
    {
        $service = new TokenEncryptionService([
            'payload' => [
                'uid' => $user->getKey(),
            ],
            'public_key' => File::get(storage_path('app/id_rsa.pub')),
        ]);
        $this->server['HTTP_AUTHORIZATION'] = 'Bearer '.$service->run();
    }

    public function setInputParam($key, $value)
    {
        $this->input[$key] = $value;
    }

    public function setRouteParam($key, $value)
    {
        $replace = $value;
        $subject = $this->url;
        $search = '{'.$key.'}';

        $this->url = str_replace($search, $replace, $subject);
    }

    public function setServerParam($key, $value)
    {
        $this->server[$key] = $value;
    }

    public function when($func)
    {
        $this->url = $this->uri;
        $this->input = [];
        $this->server = [];

        while (DB::transactionLevel() > 0) {
            DB::rollBack();
        }

        DB::beginTransaction();

        call_user_func($func);

        return $this;
    }
}
