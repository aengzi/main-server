<?php

namespace App\Services;

use App\Service;

class DeletingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result.model' => ['model', function ($model) {

                $model->delete();
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'model' => ['model_class', 'id', function ($modelClass, $id) {

                return $modelClass::find($id);
            }],

            'model_class' => [function () {

                throw new \Exception;
            }],

            'result' => [function () {

                return null;
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
            'model'
                => ['not_null'],
        ];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
