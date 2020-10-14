<?php

namespace App\Models;

use App\Models\AftvBcast;
use App\Models\AftvFile;
use App\Models\AftvReview;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Extend\Model;

class AftvM3u8 extends Model
{
    public $incrementing = false;
    protected $casts = [
        'review_id' => 'integer',
        'bcast_id' => 'integer',
        'm3u8_index' => 'integer',
    ];
    protected $fillable = [
        'review_id',
        'bcast_id',
        'm3u8_index',
        'file_prefix',
        'url',
        'ts_path',
        'play_path',
        'play_data',
        'data',
        'resolution',
        'ts_count',
        'duration',
        'gdrive_id',
        'validation',
    ];
    protected $hidden = [
        'play_data',
        'gdrive_id',
        'validation',
    ];

    public function bcast()
    {
        return $this->belongsTo(AftvBcast::class, 'bcast_id', 'id');
    }

    public function files()
    {
        return $this->relation(AftvFile::class, ['bcast_id', 'm3u8_index'], ['bcast_id', 'm3u8_index'], true);
    }

    public function review()
    {
        return $this->belongsTo(AftvReview::class, 'review_id', 'id');
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query
            ->where('bcast_id', '=', $this->getAttribute('bcast_id'))
            ->where('m3u8_index', '=', $this->getAttribute('m3u8_index'));
    }
}
