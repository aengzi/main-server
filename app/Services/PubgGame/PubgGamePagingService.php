<?php

namespace App\Services\PubgGame;

use App\Relation;
use App\Service;
use App\Models\Like;
use App\Models\PubgGame;
use App\Models\PubgMeta;
use App\Services\PagingService;

class PubgGamePagingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query' => ['query', function ($query) {

                $query->whereNotNull('vod_id');
            }],

            'query.queue_sizes' => ['query', 'queue_sizes', function ($query, $queueSizes) {

                $queueSizes = preg_split('/\s*,\s*/', $queueSizes);
                $subQuery = PubgMeta::query()
                    ->select(['game_id'])
                    ->where('property', 'queue_size')
                    ->whereIn('value', $queueSizes)
                    ->getQuery();

                $query->whereIn('id', $subQuery);
            }],

            'query.map_names' => ['query', 'map_names', function ($query, $mapNames) {

                $mapNames = preg_split('/\s*,\s*/', $mapNames);
                $subQuery = PubgMeta::query()
                    ->select(['game_id'])
                    ->where('property', 'map_name')
                    ->whereIn('value', $mapNames)
                    ->getQuery();

                $query->whereIn('id', $subQuery);
            }],

            'query.order_by_array' => ['query', 'order_by_array', function ($query, $orderByArray) {

                unset($orderByArray[$query->getModel()->getKeyName()]);

                if ( ! array_key_exists('started_at', $orderByArray) )
                {
                    $orderByArray['started_at'] = 'desc';
                }

                foreach ( $orderByArray as $column => $order )
                {
                    if ( $column == 'likes' ) {

                        $table  = $query->getModel()->getTable();
                        $jTable = app(Like::class)->getTable();
                        $type   = array_flip(Relation::morphMap())[get_class($query->getModel())];

                        $query->leftJoin($jTable, function ($join) use ($table, $jTable, $type) {

                            $join
                                ->on($table.'.id', '=', $jTable.'.related_id')
                                ->where($jTable.'.related_type', $type);
                        });

                        $query->groupBy($table.'.vod_id');
                        $query->orderByRaw('count('.$table.'.vod_id) '.$order);

                    } else {

                        $model1 = $query->getModel();
                        $key1   = $model1->getTable().'.'.$model1->getKeyName();
                        $table2 = app(PubgMeta::class)->getTable();
                        $alias2 = $table2.'_order_'.$column;

                        $query->join($table2.' as '.$alias2, function ($join) use ($key1, $alias2, $column) {

                            $join->on($key1, '=', $alias2.'.game_id')
                                ->where($alias2.'.property', '=', $column);
                        });

                        $orderColumn = in_array($column, ['kills', 'assists', 'rank', 'time_survived']) ? '.value + 0 ': '.value ';

                        $query->orderByRaw($alias2.$orderColumn.$order);
                    }
                }
            }]
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_order_by' => [function () {

                return [
                    'started_at desc',
                    'kills desc',
                    'assists desc',
                    'rank asc',
                    'time_survived desc'
                ];
            }],

            'model_class' => [function () {

                return PubgGame::class;
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
