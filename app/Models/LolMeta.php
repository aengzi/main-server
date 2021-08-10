<?php

namespace App\Models;

use App\Models\LolGame;
use FunctionalCoding\Illuminate\Model;

class LolMeta extends Model
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
        return $this->belongsTo(LolGame::class, 'game_id', 'id');
    }
}
