<?php

namespace App\Models;

use App\Model;

class AftvIp extends Model
{
    public $incrementing = true;
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'ip',
    ];
    protected $guarded = ['id'];
    protected $hidden = [
    ];
}
