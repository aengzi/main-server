<?php

namespace App\Models;

use FunctionalCoding\Illuminate\Model;

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
