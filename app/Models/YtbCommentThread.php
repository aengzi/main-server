<?php

namespace App\Models;

use App\Model;
use App\Models\YtbCommentReply;

class YtbCommentThread extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
    ];
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];
    protected $fillable = [
        'id',
        'etag',
        'video_id',
        'text',
        'like_count',
        'author_name',
        'author_img_url',
        'author_channel_id',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
    ];

    public function replies()
    {
        return $this->hasMany(YtbCommentReply::class, 'thread_id', 'id');
    }
}
