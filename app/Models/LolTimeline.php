<?php

namespace App\Models;

use App\Model;

class LolTimeline extends Model
{
    public $incrementing = true;
    protected $keyType = 'integer';
    protected $casts = [
        'game_id' => 'integer',
    ];
    protected $fillable = [
        'id',
        'game_id',
        'type',
        'elapsed_timestamp'
    ];
    protected $hidden = [
    ];

    public function game()
    {
        return $this->belongsTo(LolGame::class, 'game_id', 'id');
    }

    public function getExpandable()
    {
        return ['game'];
    }
}
