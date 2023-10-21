<?php

namespace App\Models;

use App\Model;

class Vod extends Model
{
    public $incrementing = true;
    protected $appends = [
        'm3u8_url',
        'thumbnail',
    ];
    protected $casts = [
        'id' => 'integer',
        'bcast_id' => 'integer',
    ];
    protected $fillable = [
        'related_id',
        'related_type',
        'data',
        'title',
        'like_count',
        'thread_count',
        'bcast_id',
        'duration',
        'started_at',
        'ended_at',
    ];
    protected $guarded = ['id'];
    protected $hidden = [
        'data',
    ];

    public function bcast()
    {
        return $this->belongsTo(AftvBcast::class, 'bcast_id', 'id');
    }

    public function commentThreads()
    {
        return $this->morphMany(CommentThread::class, 'related');
    }

    public function getBucketNameAttribute()
    {
        return ('temp' == $this->related_type ? 'temp.' : '').'aengzi.com';
    }

    public function getM3u8UrlAttribute()
    {
        $bucketName = $this->getBucketNameAttribute();

        return 'production' == env('APP_ENV') ? 'https://storage.googleapis.com/'.$bucketName.'/vods/'.$this->getKey().'/file.m3u8' : 'https://devstreaming-cdn.apple.com/videos/streaming/examples/img_bipbop_adv_example_fmp4/master.m3u8';
    }

    public function getThumbnailAttribute()
    {
        $bucketName = $this->getBucketNameAttribute();

        return 'production' == env('APP_ENV') ? 'https://storage.googleapis.com/'.$bucketName.'/vods/'.$this->getKey().'/origin.jpg' : 'https://via.placeholder.com/300x300';
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
}
