<?php

namespace App\Models;

use App\Models\PubgGame;
use Illuminate\Extend\Model;

class PubgMeta extends Model
{
    public $incrementing = true;
    protected $guarded = ['id'];
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
}
