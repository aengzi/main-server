<?php

namespace App\Services\AftvBcast;

use App\Relation;
use App\Service;
use App\Models\AftvBcast;
use App\Models\AftvReview;
use App\Models\Vod;
use App\Services\PagingService;

class AftvBcastPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.order_by_array' => ['query', 'order_by_array', function ($query, $orderByArray) {

                foreach ( $orderByArray as $column => $order )
                {
                    if ( $column == 'like_count' ) {

                        $model1 = $query->getModel();
                        $key1   = $model1->getTable().'.'.$model1->getKeyName();
                        $table2 = app(AftvReview::class)->getTable();
                        $table3 = app(Vod::class)->getTable();
                        $type   = array_flip(Relation::morphMap())[get_class(AftvReview::class)];

                        $query->join($table2, function ($join) use ($key1, $table2) {

                            $join->on($key1, '=', $table2.'.bcast_id');
                        });
                        $query->leftJoin($table3, function ($join) use ($table2, $table3, $type) {

                            $join
                                ->on($table2.'.id', '=', $table3.'.related_id')
                                ->where($table3.'.related_type', $type);
                        });

                        $query->groupBy($table2.'.bcast_id');
                        $query->orderByRaw('sum('.$table3.'.like_count) '.$order);

                    } else {

                        $query->orderBy($column, $order);
                    }
                }
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_order_by' => [function () {

                return ['started_at desc', 'started_at asc', 'like_count desc'];
            }],

            'model_class' => [function () {

                return AftvBcast::class;
            }],

            'order_by' => [function () {

                return 'started_at desc';
            }]
        ];
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
        return [
            PagingService::class
        ];
    }
}
