<?php

namespace App\Models;

use App\Model;

class AftvBcast extends Model
{
    public $incrementing = false;
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'id',
        'bj_user_id',
        'duration',
        'started_at',
        'ended_at',
        'gdrive_id',
    ];
    protected $hidden = [
        'gdrive_id',
    ];

    public function bj()
    {
        return $this->belongsTo(AftvBj::class, 'bj_user_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(AftvFile::class, 'bcast_id', 'id');
    }

    public function m3u8s()
    {
        return $this->hasMany(AftvM3u8::class, 'bcast_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(AftvReview::class, 'bcast_id', 'id');
    }

    public function vod()
    {
        return $this->morphOne(Vod::class, 'related');
    }
}
