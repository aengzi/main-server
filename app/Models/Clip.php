<?php

namespace App\Models;

use App\Model;
use App\Models\User;
use App\Models\Vod;

class Clip extends Model
{
    const CREATED_AT = 'created_at';
    public $incrementing = true;
    public $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];
    protected $fillable = [
        'user_id',
        'created_at',
    ];
    protected $hidden = [
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function vod()
    {
        return $this->morphOne(Vod::class, 'related');
    }
}
