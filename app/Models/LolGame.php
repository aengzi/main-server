<?php

namespace App\Models;

use App\Model;

class LolGame extends Model
{
    public $incrementing = false;
    protected $casts = [
        'id' => 'integer',
        'vod_id' => 'integer',
    ];
    protected $fillable = [
        'id',
        'vod_id',
        'account_id',
        'matches',
        'timelines',
        'created_at',
        'started_at',
        'participant_id',
        'time_sh_file_id',
        'time_sh_at',
        'time_sh_img',
        'time_sh_elapsed_sec',
    ];
    protected $hidden = [
        'timelines',
        'time_sh_file_id',
        'time_sh_at',
        'time_sh_img',
        'time_sh_elapsed_sec',
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

    public function getThumbnailAttribute($value)
    {
        return 'https://storage.googleapis.com/aengzi.com/vods/'.$this->vod_id.'/origin.jpg';
    }

    public function getTimeShImgAttribute($value) // blob data cause error when serializing without this
    {
        return base64_encode($value);
    }
}
