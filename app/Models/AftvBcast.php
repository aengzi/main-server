<?php

namespace App\Models;

use App\Model;
use App\Models\AftvBj;
use App\Models\AftvFile;
use App\Models\AftvM3u8;
use App\Models\AftvReview;
use App\Models\Vod;

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
        'gdrive_id'
    ];
    protected $hidden = [
        'gdrive_id'
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

    // public function vod()
    // {
    //     return $this->belongsTo(Vod::class, 'vod_id', 'id');
    // }

    // public function getM3u8UrlAttribute()
    // {
    //     return 'https://storage.googleapis.com/aengzi.com/vods/'.$this->vod_id.'/file.m3u8';
    // }

    public function getExpandable()
    {
        return ['bj', 'm3u8s', 'reviews', 'reviews.vod'];
    }
}
