<?php

namespace App;

use App\Validator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Factory as ValidationFactory;

/**
 * todo test
 * xxxx.* not exist in promise list, loader, callback list
 */
class Service {

    const BIND_NAME_EXP = '/\{\{([a-z0-9\_\.\*]+)\}\}/';

    protected $childs;
    protected $data;
    protected $errors;
    protected $inputs;
    protected $names;
    protected $processed;
    protected $validated;

    public function __construct(array $inputs = [], array $names = [])
    {
        $this->childs    = inst(Collection::class);
        $this->data      = inst(Collection::class);
        $this->errors    = inst(Collection::class);
        $this->inputs    = inst(Collection::class, [$inputs]);
        $this->names     = inst(Collection::class, [$names]);
        $this->validated = inst(Collection::class);
        $this->processed = false;
    }

    public function childs()
    {
        return $this->childs;
    }

    public function data()
    {
        $data = $this->data->all();

        ksort($data);

        return inst(Collection::class, [$data]);
    }

    public function errors()
    {
        return clone $this->errors;
    }

    public function totalErrors()
    {
        $errors = $this->errors()->flatten();

        foreach ( $this->childs() as $child )
        {
            $errors = $errors->merge($child->totalErrors());
        }

        return $errors;
    }

    public static function getAllBindNames()
    {
        $arr = [];

        foreach ( static::getArrTraits() as $class )
        {
            $arr = array_merge($arr, $class::getAllBindNames()->all());
        }

        $arr = array_merge($arr, static::getArrBindNames());

        return inst(Collection::class, [$arr]);
    }

    public static function getAllCallbackLists()
    {
        $arr = [];

        foreach ( static::getArrTraits() as $class )
        {
            $arr = array_merge_recursive($arr, $class::getAllCallbackLists()->all());
        }

        foreach ( static::getArrCallbackLists() as $key => $resolver )
        {
            $keys = explode('.', $key);
            $key1 = $keys[0];
            $key2 =array_key_exists(1, $keys) ? $keys[1] : 0;

            if ( ! array_key_exists($key1, $arr) )
            {
                $arr[$key1] = [];
            }

            $arr[$key1][$key2] = $resolver;
        }

        return inst(Collection::class, [$arr]);
    }

    public static function getAllLoaders()
    {
        $arr = [];

        foreach ( static::getArrTraits() as $class )
        {
            $arr = array_merge($arr, $class::getAllLoaders()->all());
        }

        $arr = array_merge($arr, static::getArrLoaders());

        return inst(Collection::class, [$arr]);
    }

    public static function getAllPromiseLists()
    {
        $arr = [];

        foreach ( static::getArrTraits() as $class )
        {
            $arr = array_merge_recursive($arr, $class::getAllPromiseLists()->all());
        }

        $arr = array_merge_recursive($arr, static::getArrPromiseLists());

        return inst(Collection::class, [$arr]);
    }

    public static function getAllRuleLists()
    {
        $arr = [];

        foreach ( static::getArrTraits() as $class )
        {
            $arr = array_merge_recursive($arr, $class::getAllRuleLists()->all());
        }

        $arr = array_merge_recursive($arr, static::getArrRuleLists());

        return inst(Collection::class, [$arr]);
    }

    public static function getAllTraits()
    {
        $arr = [];

        foreach ( static::getArrTraits() as $class )
        {
            $arr = array_merge_recursive($arr, $class::getAllTraits()->all());
        }

        $arr = array_merge_recursive($arr, static::getArrTraits());

        return inst(Collection::class, [$arr]);
    }

    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [];
    }

    public static function getArrTraits()
    {
        return [];
    }

    protected function getDependencies($key)
    {
        $loader       = $this->getAllLoaders()->get($key, []);
        $ruleList     = $this->getAllRuleLists()->get($key, []);
        $callbackList = $this->getAllCallbackLists()->get($key, []);
        $deps         = array_slice($loader, 0, -1);

        // foreach ( $ruleList as $rule )
        // {
        //     $deps = array_merge($deps, $this->getBindKeys($rule));
        // }

        // foreach ( $this->getAllRuleLists()->get($key.'.*', []) as $rule )
        // {
        //     $deps = array_merge($deps, $this->getBindKeys($rule));
        // }

        foreach ( $callbackList as $callback )
        {
            $deps = array_merge($deps, array_slice($callback, 1, -1));
        }

        return $deps;
    }

    protected function getValidationErrors($data, $ruleList)
    {
        $factory = inst(ValidationFactory::class);
        $factory->resolver(function ($tr, array $data, array $rules, array $messages, array $names) {

            return new Validator($tr, $data, $rules, $messages, $names);
        });

        foreach ( $ruleList as $key => $rules )
        {
            $validator = $factory->make($data->toArray(), [$key => $rules], [], $this->names->toArray());
            $validator->passes();

            if ( !empty($validator->errors()->all()) )
            {
                $errors = $this->errors->get($key, []);
                $errors = array_merge($errors, $validator->errors()->all());

                $this->errors->put($key, $errors);
            }
        }

        return $this->errors->get($key, []);
    }

    public function hasInvalidDepandencyLoader($key)
    {
        $loader = $this->getAllLoaders()->get($key, []);
        $deps   = array_slice($loader, 0, -1);

        foreach ( $deps as $dep )
        {
            if ( ! $this->validated->get($dep) )
            {
                return true;
            }
        }

        return false;
    }

    public function inputs()
    {
        return clone $this->inputs;
    }

    protected function isResolveError($value)
    {
        $errorClass = get_class($this->resolveError());

        return is_object($value) && $value instanceof $errorClass;
    }

    protected function initService($value)
    {
        $value = array_add($value, 1, []);
        $value = array_add($value, 2, []);

        $class = $value[0];
        $data  = $value[1];
        $names = $value[2];

        foreach ( $names as $key => $name )
        {
            $names[$key] = $this->resolveBindName($name);
        }

        return inst($class, [$data, $names]);
    }

    protected function resolve(array $arr = [])
    {
        $resolver = \Closure::bind(array_last($arr), $this);
        $depNames = array_slice($arr, 0, -1);
        $depVals  = [];
        $params   = (new \ReflectionFunction($resolver))->getParameters();

        foreach ( $depNames as $i => $depName )
        {
            if ( $this->data->has($depName) )
            {
                $depVals[] = $this->data->get($depName);
            }
            else if ( $params[$i]->isDefaultValueAvailable() )
            {
                $depVals[] = $params[$i]->getDefaultValue();
            }
            else
            {
                // must not throw exception, but only return
                return $this->resolveError();
            }
        }

        return call_user_func_array($resolver, $depVals);
    }

    protected function getAvailableDataWith($key)
    {
        $key  = explode('.', $key)[0];
        $data = $this->data();

        if ( $this->inputs()->has($key) )
        {
            $value = $this->inputs()->get($key);

            $data->put($key, $value);
        }
        else if ( ! $this->data()->has($key) && $this->getAllLoaders()->has($key) )
        {
            $loader = $this->getAllLoaders()->get($key);
            $value  = $this->resolve($loader);

            if ( is_array($value) && array_key_exists(0, $value) && is_string($value[0]) && Str::endsWith($value[0], 'Service') )
            {
                if ( !class_exists($value[0]) )
                {
                    throw new \Exception($value[0].' class not exist.');
                }

                $service = $this->initService($value);
                $value   = $service->run();

                $this->childs->put($key, $service);
            }

            if ( ! $this->isResolveError($value) )
            {
                $data->put($key, $value);
            }
        }

        return $data;
    }

    protected function getAvailableRulesWith($key)
    {
        $rules = $this->getAllRuleLists()->get($key, []);

        if ( ! $this->getAllLoaders()->has(explode('.', $key)[0]) && ! $this->inputs->has(explode('.', $key)[0]) )
        {
            // addable options: required_if, required_unless, requred_with, required_without. but this options is deprecated with trait method
            if ( in_array('required', $rules) )
            {
                $rules = ['required'];
            }
            else
            {
                $rules = [];
            }
        }

        if ( empty($rules) )
        {
            return [];
        }

        $this->names[$key] = $this->resolveBindName('{{'.$key.'}}');

        foreach ( $rules as $i => $rule )
        {
            $requiredNames = [];
            $bindKeys      = $this->getBindKeys($rule);

            foreach ( $bindKeys as $bindKey )
            {
                $this->names[$bindKey] = $this->resolveBindName('{{'.$bindKey.'}}');

                if ( ! $this->validate($bindKey) )
                {
                    $this->validated->put($key, false);

                    unset($rules[$i]);

                    continue;
                }

                if ( ! $this->data()->has($bindKey) )
                {
                    // throw new \Exception('"' . $bindKey . '" key required rule not exists');
                }
            }

            if ( array_key_exists($i, $rules) )
            {
                $rules[$i] = preg_replace(static::BIND_NAME_EXP, '$1', $rule);
            }
        }

        return array_values($rules);
    }

    protected function getBindKeys(string $str)
    {
        $matches = [];

        preg_match_all(static::BIND_NAME_EXP, $str, $matches);

        return $matches[1];
    }

    protected function resolveBindName(string $name)
    {
        while ( $boundKeys = $this->getBindKeys($name) )
        {
            $key      = $boundKeys[0];
            $pattern  = '/\{\{' . $key . '\}\}/';
            $bindName = $this->getAllBindNames()->merge($this->names)->get($key);

            if ( $bindName == null )
            {
                throw new \Exception('"' . $key . '" name not exists');
            }

            $replace = $this->resolveBindName($bindName);
            $name    = preg_replace($pattern, $replace, $name, 1);
        }

        return $name;
    }

    protected function resolveError()
    {
        return new \Exception('can\'t be resolve');
    }

    public function run()
    {
        if ( ! $this->processed )
        {
            // foreach ( $this->getAllBindNames()->merge($this->names) as $key => $name )
            // {
            //     $this->names[$key] = $this->resolveBindName($name);
            // }

            foreach ( $this->inputs()->keys() as $key )
            {
                $this->validate($key);
            }

            foreach ( $this->getAllRuleLists()->keys() as $key )
            {
                $this->validate(explode('.', $key)[0]);
            }

            foreach ( $this->getAllLoaders()->keys() as $key )
            {
                $this->validate($key);
            }

            $this->processed = true;
        }

        if ( ! $this->totalErrors()->isEmpty() )
        {
            return $this->resolveError();
        }

        if ( ! $this->data()->has('result') )
        {
            throw new \Exception('result data key is not exists');
        }

        return $this->data()->get('result');
    }

    protected function validate($key)
    {
        if ( count(explode('.', $key)) > 1 )
        {
            // $this->validate(explode('.', $key)[0]);
            throw new \Exception('does not support validation with child key');
        }

        if ( $this->validated->has($key) )
        {
            return $this->validated->get($key);
        }

        $promiseList = $this->getAllPromiseLists()->get($key, []);

        foreach ( $promiseList as $promise )
        {
            $segs       = explode(':', $promise);
            $promiseKey = array_shift($segs);
            $isStrict   = array_shift($segs) == 'strict';
            $validated  = $this->validate($promiseKey);

            if ( !$validated && $isStrict )
            {
                $this->validated->put($key, false);

                return false;
            }
        }

        $deps = $this->getDependencies($key);

        foreach ( $deps as $dep )
        {
            if ( ! $this->validate($dep) )
            {
                $this->validated->put($key, false);
            }
        }

        if ( $this->hasInvalidDepandencyLoader($key) )
        {
            return false;
        }

        $ruleList = [$key => $this->getAvailableRulesWith($key)];
        $data     = $this->getAvailableDataWith($key);

        if ( $this->getAllRuleLists()->has($key.'.*') )
        {
            $ruleList[$key.'.*'] = $this->getAvailableRulesWith($key.'.*');
        }

        $errors = $this->getValidationErrors($data, $ruleList);

        if ( ! empty($errors) || ($this->childs->has($key) && ! $this->childs->get($key)->totalErrors()->isEmpty()) )
        {
            $this->validated->put($key, false);

            return false;
        }

        if ( ! $this->validated->has($key) )
        {
            if ( $data->has($key) )
            {
                $this->data->put($key, $data->get($key));
            }

            $this->validated->put($key, true);

            $callbackList = $this->getAllCallbackLists()->get($key, []);

            foreach ( $callbackList as $callback )
            {
                $this->resolve($callback);
            }

            return true;
        }

        return false;
    }

    public function validated()
    {
        $list = $this->validated->all();

        ksort($list);

        return inst(Collection::class, [$list]);
    }

}
