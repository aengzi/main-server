<?php

namespace App\Models;

use App\Model;

class LolMeta extends Model
{
    public $incrementing = true;
    public $guarded = ['id'];
    protected $keyType = 'integer';
    protected $casts = [
        'game_id' => 'integer'
    ];
    protected $fillable = [
        'game_id',
        'property',
        'value'
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
