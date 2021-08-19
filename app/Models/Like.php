<?php

namespace App\Models;

use App\Model;

class Like extends Model
{
    public const CREATED_AT = 'created_at';
    public $incrementing = true;
    protected $guarded = ['id'];
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function related()
    {
        return $this->morphTo('related');
    }
}
