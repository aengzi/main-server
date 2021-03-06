<?php

namespace App\Models;

use App\Model;

class YtbVideo extends Model
{
    public const CREATED_AT = 'created_at';
    public $incrementing = true;
    protected $appends = [
        'thumbnail',
    ];
    protected $casts = [
        'id' => 'integer',
    ];
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
    protected $fillable = [
        'id',
        'ytb_id',
        'like_count',
        'channel_id',
        'title',
        'created_at',
    ];
    protected $guarded = ['id'];
    protected $hidden = [
    ];

    public function getThumbnailAttribute($value)
    {
        return 'https://i.ytimg.com/vi/'.$this->ytb_id.'/mqdefault.jpg'; // maxresdefault
    }

    public function like()
    {
        return $this->relation(Like::class, [':model_type:', 'id', ':auth_user_id:'], ['related_type', 'related_id', 'user_id'], false);
    }
}
