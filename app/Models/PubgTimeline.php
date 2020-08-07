<?php

namespace App\Models;

use App\Model;

class PubgTimeline extends Model
{
    public $incrementing = true;
    public $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'game_id' => 'integer',
    ];
    protected $fillable = [
        'game_id',
        'type',
        'elapsed_sec',
    ];
    protected $hidden = [
    ];
}
