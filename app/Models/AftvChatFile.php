<?php

namespace App\Models;

use App\Model;
use App\Models\AftvBcast;
use App\Models\AftvReview;
use Illuminate\Database\Eloquent\Builder;

class AftvChatFile extends Model
{
    public $incrementing = false;
    protected $casts = [
        'bcast_id' => 'integer',
        'm3u8_index' => 'integer',
        'review_id' => 'integer'
    ];
    protected $fillable = [
        'bcast_id',
        'm3u8_index',
        'review_id',
        'row_key',
        'data'
    ];
    protected $hidden = [
    ];

    public function bcast()
    {
        return $this->belongsTo(AftvBcast::class, 'bcast_id', 'id');
    }

    public function review()
    {
        return $this->belongsTo(AftvReview::class, 'review_id', 'id');
    }

    public function getExpandable()
    {
        return ['bcast', 'review'];
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query
            ->where('bcast_id', '=', $this->getAttribute('bcast_id'))
            ->where('m3u8_index', '=', $this->getAttribute('m3u8_index'));
    }
}
