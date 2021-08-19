<?php

namespace App\Models;

use App\Model;

class LolTimeline extends Model
{
    public $incrementing = true;
    protected $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'game_id' => 'integer',
    ];
    protected $fillable = [
        'game_id',
        'type',
        'elapsed_timestamp',
    ];
    protected $hidden = [
    ];

    public function game()
    {
        return $this->belongsTo(LolGame::class, 'game_id', 'id');
    }
}
