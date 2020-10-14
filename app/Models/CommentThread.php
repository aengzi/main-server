<?php

namespace App\Models;

use App\Models\Dislike;
use App\Models\Like;
use App\Models\User;
use Illuminate\Extend\Model;

class CommentThread extends Model
{
    protected $table = 'comment_threads';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $incrementing = true;
    public $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'related_id' => 'integer',
    ];
    protected $fillable = [
        'user_id',
        'related_id',
        'related_type',
        'like_count',
        'dislike_count',
        'reply_count',
        'message',
        'created_at',
        'updated_at',
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

    public function related()
    {
        return $this->morphTo('related');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
