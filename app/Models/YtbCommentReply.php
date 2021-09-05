<?php

namespace App\Models;

use App\Model;

class YtbCommentReply extends Model
{
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public $incrementing = false;
    protected $casts = [
    ];
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
    protected $fillable = [
        'id',
        'etag',
        'thread_id',
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
    protected $keyType = 'string';

    public function thread()
    {
        return $this->belongsTo(YtbCommentThread::class, 'thread_id', 'id');
    }
}
