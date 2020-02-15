<?php

namespace App\Services;

use App\Service;
use App\Services\Auth\AuthUserFindingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FindingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'available_expands'
                => 'options for {{expands}}',

            'available_fields'
                => 'options for {{fields}}'
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result' => ['result', 'expands', function ($result, $expands) {

                $expands = preg_split('/\s*,\s*/', $expands);
                $collection = $result->newCollection();
                $collection->push($result);
                $collection->loadVisible($expands);
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

                return array_merge($model->getFillable(), $model->getGuarded());
            }],

            'model_class' => [function () {

                throw new \Exception;
            }],

            'result' => ['id', 'fields', 'model_class', function ($id, $fields=null, $modelClass) {

                if ( $fields == null )
                {
                    $model = inst($modelClass);
                    $availableFields = array_merge($model->getFillable(), $model->getGuarded());
                    $fields = implode(',', array_diff($availableFields, $model->getHidden()));
                }

                $fields = preg_split('/\s*,\s*/', $fields);

                return inst($modelClass)->find($id, $fields);
            }]
        ];
    }

    public static function getArrPromiseLists()
    {
        return [
            'result'
                => ['auth_user']
        ];
    }

    public static function getArrRuleLists()
    {
        return [
            'expands'
                => ['string', 'several_in:{{available_expands}}'],

            'fields'
                => ['string', 'several_in:{{available_fields}}'],

            'id'
                => ['required', 'integer'],

            'result'
                => ['not_null']
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }

}
