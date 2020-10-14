<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Extend\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    const CREATED_AT = 'created_at';
    public $incrementing = true;
    public $guarded = ['id'];
    protected $appends = [
        'thumbnail',
    ];
    protected $casts = [
        'id' => 'integer',
    ];
    protected $fillable = [
        'nick',
        'email',
        'password',
        'has_thumbnail',
        'created_at',
    ];
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getThumbnailAttribute()
    {
        if ( $this->has_thumbnail )
        {
            return 'https://storage.googleapis.com/aengzi.com/users/'.$this->getKey().'/origin.jpg';
        }
    }
}

