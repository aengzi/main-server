<?php

namespace App\Models;

use App\Model;
use App\Models\CommentThread;
use App\Models\User;

class CommentReply extends Model
{
    protected $table = 'comment_replies';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $incrementing = true;
    public $guarded = ['id'];
    protected $casts = [
        'user_id' => 'integer',
        'thread_id' => 'integer'
    ];
    protected $fillable = [
        'user_id',
        'thread_id',
        'message',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
    ];
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT
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

    public function getExpandable()
    {
        return ['user', 'thread'];
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
