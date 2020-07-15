<?php

namespace App\Services;

use App\Service;
use App\Services\ListingService;

class CursoringService extends Service
{
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
        return [
            'limit' => [function () {

                return 10;
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

            'cursor' => ['model_class', 'cursor_id', function ($modelClass, $cursorId) {

                return $modelClass::find($cursorId);
            }],

            'result' => ['model_class', 'query', 'order_by_array', 'limit', 'cursor', function ($modelClass, $query, $orderByArray, $limit, $cursor='') {

                if ( $cursor )
                {
                    $wheres = [];
                    $result = [];

                    foreach ( $orderByArray as $column => $direction )
                    {
                        if ( $direction == 'asc' )
                        {
                            $wheres[] = [$column, '>', $cursor->{$column}];
                        }
                        else
                        {
                            $wheres[] = [$column, '<', $cursor->{$column}];
                        }
                    }

                    while ( $limit != 0 && count($wheres) != 0 )
                    {
                        $newQuery = clone $query;

                        foreach ( $wheres as $i => $where )
                        {
                            if ( $where == end($wheres) )
                            {
                                $newQuery->where($where[0], $where[1], $where[2]);
                            }
                            else
                            {
                                $newQuery->where($where[0], '=', $where[2]);
                            }
                        }

                        array_pop($wheres);

                        $list   = $newQuery->limit($limit);
                        $limit  = $limit - count($list);
                        $result = array_merge($result, $list->all());
                    }

                    return (new $modelClass)->newCollection($result);
                }
                else
                {
                    return $query->limit($limit)->get();
                }
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
            'cursor'
                => ['not_null'],

            'cursor_id'
                => ['integer'],

            'limit'
                => ['integer', 'max:120']
        ];
    }

    public static function getArrTraits()
    {
        return [
            ListingService::class
        ];
    }
}
