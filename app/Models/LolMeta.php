<?php

namespace App\Models;

use App\Model;

class LolMeta extends Model
{
    public $incrementing = true;
    protected $casts = [
        'id' => 'integer',
        'game_id' => 'integer',
    ];
    protected $fillable = [
        'game_id',
        'property',
        'value',
    ];
    protected $guarded = ['id'];
    protected $hidden = [
    ];

    public function game()
    {
        return $this->belongsTo(LolGame::class, 'game_id', 'id');
    }
}
