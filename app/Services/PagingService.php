<?php

namespace App\Services;

use App\Service;
use App\Services\ListingService;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PagingService extends Service {

    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.limit' => ['query', 'limit', function ($query, $limit) {

                $query->limit($limit);
            }],

            'query.skip' => ['query', 'skip', function ($query, $skip) {

                $query->skip($skip);
            }],

            'select_query.fields' => ['select_query', 'available_fields', 'fields', function ($selectQuery, $availableFields, $fields='') {

                $fields = $fields ? preg_split('/\s*,\s*/', $fields) : $availableFields;

                $selectQuery->select($fields);
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'limit' => [function () {

                return 12;
            }],

            'order_by' => ['model_class', function ($modelClass) {

                if ( $modelClass::CREATED_AT == null )
                {
                    throw new \Exception;
                }
                else
                {
                    return 'created_at desc';
                }
            }],

            'page' => [function () {

                return 1;
            }],

            'result' => ['limit', 'page', 'query', 'select_query', function ($limit, $page, $query, $selectQuery) {

                $query = (clone $query)->toBase();
                $query->limit = null;
                $query->offset = null;

                return app()->makeWith(LengthAwarePaginator::class, [
                    'items' => $selectQuery->get(),
                    'total' => $query->count(),
                    'perPage' => $limit,
                    'currentPage' => $page,
                    'options' => [
                        'path' => Paginator::resolveCurrentPath(),
                        'pageName' => 'page',
                    ]
                ]);
            }],

            'select_query' => ['query', 'skip', 'limit', function ($query, $skip, $limit) {

                $model       = $query->getModel();
                $selectQuery = $model->query();
                $query       = (clone $query)->select($model->getKeyName());
                $ids         = $query->get()->modelKeys();

                $selectQuery->whereIn($model->getKeyName(), $ids);

                if ( ! empty($ids) )
                {
                    if ( $model->getKeyType() == 'string' )
                    {
                        foreach ( $ids as $i => $id )
                        {
                            $ids[$i] = '\''.$id.'\'';
                        }
                    }

                    $selectQuery->orderByRaw('FIELD('.$model->getKeyName().','.implode(',', $ids).')');
                }

                return $selectQuery;
            }],

            'skip' => ['page', 'limit', function ($page, $limit) {

                return ( $page - 1 ) * $limit;
            }],
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [
            'cursor_id'
                => ['integer'],

            'limit'
                => ['integer', 'max:100'],

            'page'
                => ['integer']
        ];
    }

    public static function getArrTraits()
    {
        return [
            ListingService::class
        ];
    }

}
