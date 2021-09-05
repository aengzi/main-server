<?php

namespace App\Models;

use App\Model;

class GoogleClient extends Model
{
    public $incrementing = true;
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'user',
        'credential',
        'access_token',
    ];
    protected $guarded = ['id'];
    protected $hidden = [
    ];
}
