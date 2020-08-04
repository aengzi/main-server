<?php

namespace App\Models;

use App\Model;
use App\Models\PubgGame;

class PubgMeta extends Model
{
    public $incrementing = true;
    public $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'game_id' => 'integer',
    ];
    protected $fillable = [
        'game_id',
        'property',
        'value',
    ];
    protected $hidden = [
    ];

    public function game()
    {
        return $this->belongsTo(PubgGame::class, 'game_id', 'id');
    }

    public function getExpandable()
    {
        return ['game'];
    }
}
