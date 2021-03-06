<?php

namespace App\Models;

use App\Model;

class AftvBj extends Model
{
    public $incrementing = false;
    protected $casts = [
        'station_id' => 'integer',
        'bbs_id' => 'integer',
    ];
    protected $fillable = [
        'id',
        'nick',
        'station_id',
        'bbs_id',
        'gdrive_id',
    ];
    protected $hidden = [
        'gdrive_id',
    ];
    protected $keyType = 'string';

    public function bcasts()
    {
        return $this->hasMany(AftvBcast::class, 'bj_user_id', 'id');
    }
}
