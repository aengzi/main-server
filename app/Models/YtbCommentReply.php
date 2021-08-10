<?php

namespace App\Models;

use App\Models\YtbCommentThread;
use FunctionalCoding\Illuminate\Model;

class YtbCommentReply extends Model
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

    public function thread()
    {
        return $this->belongsTo(YtbCommentThread::class, 'thread_id', 'id');
    }
}
