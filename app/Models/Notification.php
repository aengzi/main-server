<?php

namespace App\Models;

use App\Model;

class Notification extends Model
{
    const CREATED_AT = 'created_at';

    public $incrementing = true;
    public $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'id',
        'type',
        'description',
        'created_at',
    ];
    protected $hidden = [
    ];
}
