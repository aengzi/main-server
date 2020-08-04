<?php

namespace App\Models;

use App\Model;
use App\Models\AftvBcast;
use App\Models\AftvM3u8;
use Illuminate\Database\Eloquent\Builder;

class AftvFile extends Model
{
    public $incrementing = false;
    protected $appends = [
        'url',
    ];
    protected $casts = [
        'bcast_id' => 'integer',
        'm3u8_index' => 'integer',
        'file_index' => 'integer',
    ];
    protected $fillable = [
        'bcast_id',
        'm3u8_index',
        'file_index',
        'duration',
        'started_at',
        'ended_at',
        'gdrive_id',
    ];
    protected $hidden = [
        'gdrive_id',
    ];

    public function bcast()
    {
        return $this->belongsTo(AftvBcast::class, 'bcast_id', 'id');
    }

    public function m3u8()
    {
        return $this->relation(AftvM3u8::class, ['bcast_id', 'm3u8_index'], ['bcast_id', 'm3u8_index'], false);
    }

    public function getExpandable()
    {
        return ['bcast', 'm3u8'];
    }

    public function getUrlAttribute()
    {
        return $this->m3u8->ts_path.'/'.str_replace('###', $this->file_index, $this->m3u8->file_prefix);
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query
            ->where('bcast_id', '=', $this->getAttribute('bcast_id'))
            ->where('m3u8_index', '=', $this->getAttribute('m3u8_index'))
            ->where('file_index', '=', $this->getAttribute('file_index'));
    }
}
