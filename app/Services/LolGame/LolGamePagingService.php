<?php

namespace App\Services\LolGame;

use App\Models\Like;
use App\Models\LolGame;
use App\Models\LolMeta;
use Illuminate\Extend\Relation;
use FunctionalCoding\Service;
use Illuminate\Extend\Service\Database\PaginationListService;

class LolGamePagingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [
            'query' => function ($query) {

                $query->whereNotNull('vod_id');
            },

            'query.champion_ids' => function ($championIds, $query) {

                $championIds = preg_split('/\s*,\s*/', $championIds);
                $subQuery = LolMeta::query()
                    ->select(['game_id'])
                    ->where('property', 'status_champion_id')
                    ->whereIn('value', $championIds)
                    ->getQuery();

                $query->whereIn('id', $subQuery);
            },

            'query.is_win' => function ($isWin, $query) {

                $subQuery = LolMeta::query()
                    ->select(['game_id'])
                    ->where('property', 'my_team_win')
                    ->where('value', $isWin)
                    ->getQuery();

                $query->whereIn('id', $subQuery);
            },

            'query.multi_kill_types' => function ($multiKillTypes, $query) {

                $multiKillTypes = preg_split('/\s*,\s*/', $multiKillTypes);
                $subQuery = LolMeta::query()
                    ->select(['game_id'])
                    ->where('property', 'status_has_multi_kill_type')
                    ->whereIn('value', $multiKillTypes)
                    ->getQuery();

                $query->whereIn('id', $subQuery);
            },

            'query.order_by_array' => function ($orderByArray, $query) {

                if ( array_keys($orderByArray)[count($orderByArray)-1] == $query->getModel()->getKeyName() )
                {
                    array_pop($orderByArray);
                }

                if ( ! array_key_exists('game_creation', $orderByArray) )
                {
                    $orderByArray['game_creation'] = 'desc';
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
                        $table2 = app(LolMeta::class)->getTable();
                        $alias2 = $table2.'_order_'.$column;

                        $query->join($table2.' as '.$alias2, function ($join) use ($key1, $alias2, $column) {

                            $join->on($key1, '=', $alias2.'.game_id')
                                ->where($alias2.'.property', '=', $column);
                        });

                        $orderColumn = in_array($column, ['game_duration', 'status_kills', 'status_assists', 'status_gold_earned']) ? '.value + 0 ': '.value ';

                        $query->orderByRaw($alias2.$orderColumn.$order);
                    }
                }
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => function () {

                return ['metas', 'vod', 'vod.like', 'vod.bcast', 'vod.bcast.bj', 'timelines'];
            },

            'available_order_by' => function () {

                return [
                    'game_creation desc',
                    'game_duration desc',
                    'status_kills desc',
                    'status_assists desc',
                    'status_gold_earned desc'
                ];
            },

            'cursor' => function ($cursorId, $modelClass) {

                return $modelClass::find($cursorId);
            },

            'model_class' => function () {

                return LolGame::class;
            },

            'order_by' => function () {

                return 'game_creation desc';
            },
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
