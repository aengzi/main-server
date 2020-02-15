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
            'query.skip' => ['query', 'skip', function ($query, $skip) {

                $query->skip($skip);
            }],

            'query.limit' => ['query', 'limit', function ($query, $limit) {

                $query->take($limit);
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

            'skip' => ['page', 'limit', function ($page, $limit) {

                return ( $page - 1 ) * $limit;
            }],

            'result' => ['limit', 'page', 'query', 'select_query', function ($limit, $page, $query, $selectQuery) {

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
