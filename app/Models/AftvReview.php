<?php

namespace App\Models;

use App\Model;
use App\Models\AftvBcast;
use App\Models\AftvBj;
use App\Models\AftvM3u8;
use App\Models\Vod;

class AftvReview extends Model
{
    public $incrementing = false;
    protected $casts = [
        'bcast_id' => 'integer',
    ];
    protected $fillable = [
        'id',
        'bj_user_id',
        'bcast_id',
        'info',
        'm3u8_count',
        'duration',
        'playlist_id',
        'registered_at',
        'started_at',
        'ended_at',
    ];
    protected $hidden = [
        'info',
    ];

    public function bcast()
    {
        return $this->belongsTo(AftvBcast::class, 'bcast_id', 'id');
    }

    public function bj()
    {
        return $this->belongsTo(AftvBj::class, 'bj_user_id', 'id');
    }

    public function m3u8s()
    {
        return $this->hasMany(AftvM3u8::class, 'review_id', 'id');
    }

    public function vod()
    {
        return $this->morphOne(Vod::class, 'related');
    }

    public function getExpandable()
    {
        return ['bcast', 'bcast.reviews', 'bcast.reviews.vod', 'bj', 'm3u8s', 'vod', 'vod.like'];
    }
}
