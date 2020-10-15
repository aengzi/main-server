<?php

namespace App\Models;

use App\Models\PubgMeta;
use App\Models\PubgTimeline;
use App\Models\Vod;
use Illuminate\Extend\Model;

class PubgGame extends Model
{
    public $incrementing = true;
    protected $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'vod_id' => 'integer',
    ];
    protected $fillable = [
        'vod_id',
        'match_id',
        'participant_id',
        'started_at',
        'offset',
        'summary',
        'match',
        'deaths',
    ];
    protected $hidden = [
        'offset',
        'match',
        'deaths',
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

    public function getThumbnailAttribute($value)
    {
        return 'https://storage.googleapis.com/aengzi.com/vods/'.$this->vod_id.'/origin.jpg';
    }
}
