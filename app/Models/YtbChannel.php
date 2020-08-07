<?php

namespace App\Models;

use App\Model;

class YtbChannel extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
    ];
    protected $fillable = [
        'id',
        'title',
    ];
    protected $hidden = [
    ];
}
