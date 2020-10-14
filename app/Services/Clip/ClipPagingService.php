<?php

namespace App\Services\Clip;

use App\Relation;
use App\Service;
use App\Models\Clip;
use App\Models\User;
use App\Models\Vod;
use App\Services\PagingService;

class ClipPagingService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'user'
                => 'user for {{user_id}}',

            'vod'
                => 'vod for {{vod_id}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query.order_by_array' => ['order_by_array', 'query', function ($orderByArray, $query) {

                foreach ( $orderByArray as $column => $order )
                {
                    if ( $column == 'like_count' )
                    {
                        $table  = $query->getModel()->getTable();
                        $jTable = app(Vod::class)->getTable();
                        $type   = array_flip(Relation::morphMap())[get_class($query->getModel())];

                        $query->leftJoin($jTable, function ($join) use ($table, $jTable, $type) {

                            $join
                                ->on($table.'.id', '=', $jTable.'.related_id')
                                ->where($jTable.'.related_type', $type);
                        });

                        $query->orderByRaw($jTable.'.like_count '.$order);
                    }
                    else
                    {
                        $query->orderBy($column, $order);
                    }
                }
            }],

            'query.user' => ['query', 'user', function ($query, $user) {

                $query->where('user_id', $user->getKey());
            }],

            'query.vod' => ['query', 'vod', function ($query, $vod) {

                $query->where('vod_id', $vod->getKey());
            }],
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => [function () {

                return ['user', 'vod', 'vod.like', 'vod.bcast', 'vod.bcast.bj'];
            }],

            'available_order_by' => [function () {

                return [
                    'created_at asc',
                    'created_at desc',
                    'like_count desc'
                ];
            }],

            'model_class' => [function () {

                return Clip::class;
            }],

            'user' => ['user_id', function ($userId) {

                return User::find($userId);
            }],

            'vod' => ['vod_id', function ($vodId) {

                return Vod::find($vodId);
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
            'user'
                => ['not_null'],

            'user_id'
                => ['integer'],

            'vod'
                => ['not_null'],

            'vod_id'
                => ['integer']
        ];
    }

    public static function getArrTraits()
    {
        return [
            PagingService::class
        ];
    }
}
