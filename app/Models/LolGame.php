<?php

namespace App\Models;

use App\Model;
use App\Models\LolMeta;
use App\Models\LolTimeline;
use App\Models\Vod;

class LolGame extends Model
{
    public $incrementing = false;
    protected $keyType = 'integer';
    protected $casts = [
    ];
    protected $fillable = [
        'id',
        'matches',
        'timelines',
        'created_at',
        'participant_id',
        'time_sh_file_id',
        'time_sh_at',
        'time_sh_img',
        'time_sh_elapsed_sec',
        'started_at'
    ];
    protected $hidden = [
        'timelines',
        'time_sh_file_id',
        'time_sh_at',
        'time_sh_img',
        'time_sh_elapsed_sec'
    ];

    public function metas()
    {
        return $this->hasMany(LolMeta::class, 'game_id', 'id');
    }

    public function vod()
    {
        return $this->morphOne(Vod::class, 'related');
    }

    public function timelines()
    {
        return $this->hasMany(LolTimeline::class, 'game_id', 'id');
    }

    public function getExpandable()
    {
        return ['metas', 'vod', 'vod.like', 'vod.review', 'vod.review.bj', 'timelines'];
    }

    public function getThumbnailAttribute($value)
    {
        return 'https://storage.googleapis.com/aengzi.com/vods/'.$this->vod_id.'/origin.jpg';
    }

    public function getTimeShImgAttribute($value) // blob data cause error when serializing without this
    {
    	return base64_encode($value);
    }
}
