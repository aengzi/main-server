<?php

namespace App\Models;

use App\Model;

class LolChampion extends Model
{
    public $incrementing = true;
    public $guarded = ['id'];
    protected $keyType = 'integer';
    protected $casts = [
    ];
    protected $fillable = [
        'key',
        'name'
    ];
    protected $hidden = [
    ];

    public function getExpandable()
    {
        return [];
    }
}
