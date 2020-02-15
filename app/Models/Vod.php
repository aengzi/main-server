<?php

namespace App\Models;

use App\Model;
use App\Models\AftvReview;
use App\Models\Like;
use App\Models\CommentThread;

class Vod extends Model
{
    public $incrementing = true;
    public $guarded = ['id'];
    protected $appends = ['m3u8_url', 'thumbnail'];
    protected $casts = [
        'review_id' => 'integer'
    ];
    protected $fillable = [
        'related_id',
        'related_type',
        'data',
        'title',
        'like_count',
        'thread_count',
        'review_id',
        'duration',
        'started_at',
        'ended_at'
    ];
    protected $hidden = [
        'data'
    ];

    public function getExpandable()
    {
        return ['like', 'related', 'review'];
    }

    public function related()
    {
        return $this->morphTo('related');
    }

    public function review()
    {
        return $this->belongsTo(AftvReview::class, 'review_id', 'id');
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

    public function getM3u8UrlAttribute()
    {
        $bucketName = $this->getBucketNameAttribute();

        return 'https://storage.googleapis.com/'.$bucketName.'/vods/'.$this->getKey().'/file.m3u8';
    }

    public function getThumbnailAttribute()
    {
        $bucketName = $this->getBucketNameAttribute();

        return 'https://storage.googleapis.com/'.$bucketName.'/vods/'.$this->getKey().'/origin.jpg';
    }

    public function getBucketNameAttribute()
    {
        return ($this->related_type == 'temp' ? 'temp.' : '').'aengzi.com';
    }
}
