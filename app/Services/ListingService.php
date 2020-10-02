<?php

namespace App\Services;

use App\Service;
use App\Services\Auth\AuthUserFindingService;

class ListingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'available_expands'
                => 'options for {{expands}}',

            'available_order_by'
                => 'options for {{order_by}}',

            'available_group_by'
                => 'options for {{group_by}}',

            'available_fields'
                => 'options for {{fields}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.fields' => ['query', 'available_fields', 'fields', function ($query, $availableFields, $fields='') {

                $fields = $fields ? preg_split('/\s*,\s*/', $fields) : $availableFields;

                $query->select($fields);
            }],

            'query.group_by' => ['query', 'group_by', function ($query, $groupBy) {

                $groupBy = preg_split('/\s*,\s*/', $groupBy);

                $query->groupBy($groupBy);
            }],

            'query.order_by_array' => ['query', 'order_by_array', function ($query, $orderByArray) {

                foreach ( $orderByArray as $key => $direction )
                {
                    $query->orderBy($key, $direction);
                }
            }],

            'result.expands' => ['result', 'expands', function ($result, $expands) {

                $expands = preg_split('/\s*,\s*/', $expands);

                $result->loadVisible($expands);
            }]
         ];
    }

    public static function getArrLoaders()
    {
        return [
            'auth_user' => ['token', function ($token) {

                return [AuthUserFindingService::class, [
                    'token'
                        => $token
                ], [
                    'token'
                        => '{{token}}'
                ]];
            }],

            'available_expands' => ['model_class', function ($modelClass) {

                return inst($modelClass)->getExpandable();
            }],

            'available_fields' => ['model_class', function ($modelClass) {

                $model = inst($modelClass);

                return array_diff(array_merge($model->getFillable(), $model->getGuarded()), $model->getHidden());
            }],

            'available_group_by' => [function () {

                return [];
            }],

            'available_order_by' => ['model_class', function ($modelClass) {

                if ( $modelClass::CREATED_AT == null )
                {
                    return [inst($modelClass)->getKeyName().' desc', inst($modelClass)->getKeyName().' asc'];
                }
                else
                {
                    return ['created_at desc', 'created_at asc'];
                }
            }],

            'model_class' => [function () {

                throw new \Exception;
            }],

            'order_by_array' => ['model_class', 'order_by', function ($modelClass, $orderBy) {

                $model   = inst($modelClass);
                $orderBy = preg_replace('/\s+/', ' ', $orderBy);
                $orderBy = preg_replace('/\s*,\s*/', ',', $orderBy);
                $orders  = explode(',', $orderBy);
                $array   = [];

                foreach ( $orders as $order )
                {
                    $key       = explode(' ', $order)[0];
                    $direction = str_replace($key, '', $order);

                    $array[$key] = ltrim($direction);
                }

                if ( array_keys($array)[count($array)-1] != $model->getKeyName() )
                {
                    $array[$model->getKeyName()] = end($array);
                }

                return $array;
            }],

            'query' => ['model_class', function ($modelClass) {

                $query = inst($modelClass)->query();
                $query->select($query->getModel()->getKeyName());

                return $query;
            }],

            'result' => ['query', function ($query) {

                return $query->get();
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'expands'
                => ['string', 'several_in:{{available_expands}}'],

            'fields'
                => ['string', 'several_in:{{available_fields}}'],

            'order_by'
                => ['string', 'in_array:{{available_order_by}}.*']
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
