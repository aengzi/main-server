<?php

namespace App\Models;

use Illuminate\Extend\Model;

class AftvIp extends Model
{
    public $incrementing = true;
    protected $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'ip',
    ];
    protected $hidden = [
    ];
}
