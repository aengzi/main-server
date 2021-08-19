<?php

namespace App\Models;

use App\Model;

class GoogleClient extends Model
{
    public $incrementing = true;
    protected $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'user',
        'credential',
        'access_token',
    ];
    protected $hidden = [
    ];
}
