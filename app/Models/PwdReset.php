<?php

namespace App\Models;

use App\Model;

class PwdReset extends Model
{
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public $incrementing = true;
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'email',
        'token',
        'complete',
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];
    protected $hidden = [
        'token',
    ];
}
