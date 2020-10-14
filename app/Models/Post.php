<?php

namespace App\Models;

use App\Models\CommentThread;
use App\Models\Dislike;
use App\Models\Like;
use App\Models\User;
use Illuminate\Extend\Model;

class Post extends Model
{
    protected $table = 'posts';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $incrementing = true;
    public $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
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
    protected $hidden = [
    ];
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];

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

    public function commentThreads()
    {
        return $this->morphMany(CommentThread::class, 'related');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
