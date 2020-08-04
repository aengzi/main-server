<?php

namespace App\Models;

use App\Model;

class PwdReset extends Model {

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $incrementing = true;
    public $guarded = ['id'];
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
    protected $hidden = [
        'token',
    ];

    public function getExpandable()
    {
        return [];
    }
}
