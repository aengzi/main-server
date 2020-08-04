<?php

namespace App\Models;

use App\Model;
use App\Models\User;

class Like extends Model
{
    const CREATED_AT = 'created_at';
    public $incrementing = true;
    public $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'related_id' => 'integer',
    ];
    protected $fillable = [
        'user_id',
        'related_id',
        'related_type',
        'created_at',
    ];
    protected $hidden = [
    ];

    public function getExpandable()
    {
        return ['user', 'vod', 'related'];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function related()
    {
        return $this->morphTo('related');
    }
}
