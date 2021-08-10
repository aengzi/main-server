<?php

namespace App\Models;

use FunctionalCoding\Illuminate\Model;

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
}
