<?php

namespace App\Models;

use App\Model;

class YtbVideo extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;
    public $incrementing = true;
    public $guarded = ['id'];
    protected $appends = ['thumbnail'];
    protected $casts = [
    ];
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];
    protected $fillable = [
        'id',
        'ytb_id',
        'like_count',
        'channel_id',
        'title',
        'created_at'
    ];
    protected $hidden = [
    ];

    public function getExpandable()
    {
        return ['like'];
    }

    public function like()
    {
        return $this->relation(Like::class, [':model_type:', 'id', ':auth_user_id:'], ['related_type', 'related_id', 'user_id'], false);
    }

    public function getThumbnailAttribute($value)
    {
        return 'https://i.ytimg.com/vi/'.$this->ytb_id.'/mqdefault.jpg'; // maxresdefault
    }
}
