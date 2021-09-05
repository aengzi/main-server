<?php

namespace App\Models;

use App\Model;

class Post extends Model
{
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public $incrementing = true;
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
    protected $fillable = [
        'user_id',
        'like_count',
        'dislike_count',
        'thread_count',
        'type',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];
    protected $hidden = [
    ];

    public function commentThreads()
    {
        return $this->morphMany(CommentThread::class, 'related');
    }

    public function dislike()
    {
        return $this->relation(Dislike::class, [':model_type:', 'id', ':auth_user_id:'], ['related_type', 'related_id', 'user_id'], false);
    }

    public function dislikes()
    {
        return $this->morphMany(Dislike::class, 'related');
    }

    public function like()
    {
        return $this->relation(Like::class, [':model_type:', 'id', ':auth_user_id:'], ['related_type', 'related_id', 'user_id'], false);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'related');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
