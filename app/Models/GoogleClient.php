<?php

namespace App\Models;

use Illuminate\Extend\Model;

class GoogleClient extends Model
{
    public $incrementing = true;
    public $guarded = ['id'];
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
