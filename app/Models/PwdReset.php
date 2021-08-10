<?php

namespace App\Models;

use FunctionalCoding\Illuminate\Model;

class PwdReset extends Model {

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $incrementing = true;
    protected $guarded = ['id'];
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
}
