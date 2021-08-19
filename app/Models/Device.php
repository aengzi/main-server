<?php

namespace App\Models;

use App\Model;

class Device extends Model
{
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public $incrementing = true;
    protected $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'id',
        'related_id',
        'related_type',
        'updated_at',
        'created_at',
    ];
    protected $hidden = [
    ];
}
