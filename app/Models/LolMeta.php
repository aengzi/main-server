<?php

namespace App\Models;

use App\Models\LolGame;
use Illuminate\Extend\Model;

class LolMeta extends Model
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
        return $this->belongsTo(LolGame::class, 'game_id', 'id');
    }
}
