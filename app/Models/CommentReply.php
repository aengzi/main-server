<?php

namespace App\Models;

use App\Model;

class CommentReply extends Model
{
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public $incrementing = true;
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'thread_id' => 'integer',
    ];
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
    protected $fillable = [
        'user_id',
        'thread_id',
        'message',
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];
    protected $hidden = [
    ];

    public function getCreatedAtAttribute()
    {
        // not use Carbon
        // because Database Grammer date format is Y-m-d H:i:s
        // so we can't use mileseconds in where clause when selecting
        return $this->attributes['created_at'];
    }

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function thread()
    {
        return $this->belongsTo(CommentThread::class, 'thread_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
