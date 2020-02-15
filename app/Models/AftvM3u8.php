<?php

namespace App\Models;

use App\Model;
use App\Models\AftvBcast;
use App\Models\AftvFile;
use App\Models\AftvReview;
use Illuminate\Database\Eloquent\Builder;

class AftvM3u8 extends Model
{
    public $incrementing = false;
    protected $casts = [
        'review_id' => 'integer',
        'bcast_id' => 'integer',
        'm3u8_index' => 'integer'
    ];
    protected $fillable = [
        'review_id',
        'bcast_id',
        'm3u8_index',
        'path',
        'file_prefix',
        'chunk_file',
        'chunk_data',
        'play_file',
        'play_data',
        'ts_count',
        'duration',
        'gdrive_id',
        'children_check'
    ];
    protected $hidden = [
        'chunk_data',
        'play_data',
        'gdrive_id',
        'children_check'
    ];

    public function bcast()
    {
        return $this->belongsTo(AftvBcast::class, 'bcast_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(AftvFile::class, 'm3u8_index', 'm3u8_index')
            ->where('bcast_id', $this->bcast_id);
    }

    public function review()
    {
        return $this->belongsTo(AftvReview::class, 'review_id', 'id');
    }

    public function getExpandable()
    {
        return ['bcast', 'files', 'review'];
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query
            ->where('bcast_id', '=', $this->getAttribute('bcast_id'))
            ->where('m3u8_index', '=', $this->getAttribute('m3u8_index'));
    }
}
