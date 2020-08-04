<?php

namespace App\Models;

use App\Model;

class LolChampion extends Model
{
    public $incrementing = true;
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'id',
        'key',
        'name',
    ];
    protected $hidden = [
    ];

    public function getExpandable()
    {
        return [];
    }
}
