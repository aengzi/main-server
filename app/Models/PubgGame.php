<?php

namespace App\Models;

use App\Model;
use App\Models\PubgMeta;
use App\Models\PubgTimeline;
use App\Models\Vod;

class PubgGame extends Model
{
    public $incrementing = false;
    protected $keyType = 'integer';
    protected $casts = [
        'vod_id' => 'integer'
    ];
    protected $fillable = [
        'id',
        'match_id',
        'participant_id',
        'started_at',
        'offset',
        'summary',
        'match',
        'deaths'
    ];
    protected $hidden = [
        'offset',
        'match',
        'deaths'
    ];

    public function metas()
    {
        return $this->hasMany(PubgMeta::class, 'game_id', 'id');
    }

    public function vod()
    {
        return $this->morphOne(Vod::class, 'related');
    }

    public function timelines()
    {
        return $this->hasMany(PubgTimeline::class, 'game_id', 'id');
    }

    public function getExpandable()
    {
        return ['metas', 'vod', 'vod.like', 'vod.bcast', 'vod.bcast.bj', 'timelines'];
    }

    public function getThumbnailAttribute($value)
    {
        return 'https://storage.googleapis.com/aengzi.com/vods/'.$this->vod_id.'/origin.jpg';
    }
}
