<?php

namespace App\Services\AftvBcast;

use App\Models\AftvBcast;
use App\Models\AftvReview;
use App\Models\Vod;
use Illuminate\Extend\Relation;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Database\PaginationListService;

class AftvBcastPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.order_by_array' => ['order_by_array', 'query', function ($orderByArray, $query) {

                foreach ( $orderByArray as $column => $order )
                {
                    if ( $column == 'like_count' ) {

                        $model  = $query->getModel();
                        $pKey   = $model->getTable().'.'.$model->getKeyName();
                        $vTable = app(Vod::class)->getTable();
                        $type   = array_flip(Relation::morphMap())[AftvBcast::class];

                        $query->leftJoin($vTable, function ($join) use ($pKey, $vTable, $type) {

                            $join
                                ->on($pKey, '=', $vTable.'.related_id')
                                ->where($vTable.'.related_type', $type);
                        });

                        $query->orderBy($vTable.'.like_count', $order);

                    } else {

                        $query->orderBy($column, $order);
                    }
                }
            }],

            'query.vod.related_id' => ['query', function ($query) {

                $type     = array_flip(Relation::morphMap())[AftvBcast::class];
                $subQuery = Vod::query()
                    ->select('related_id')
                    ->where('related_type', $type)
                    ->getQuery();

                $query->whereIn($query->getModel()->getKeyName(), $subQuery);
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return ['bj', 'm3u8s', 'vod', 'vod.like'];
            }],

            'available_order_by' => [function () {

                return ['started_at desc', 'started_at asc', 'like_count desc'];
            }],

            'cursor' => ['cursor_id', 'model_class', function ($cursorId, $modelClass) {

                return $modelClass::find($cursorId);
            }],

            'model_class' => [function () {

                return AftvBcast::class;
            }],

            'order_by' => [function () {

                return 'started_at desc';
            }],
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
            PaginationListService::class,
        ];
    }
}
