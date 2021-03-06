<?php

namespace App\Models;

use App\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;

    public const CREATED_AT = 'created_at';
    public $incrementing = true;
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
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
    ];

    public function getThumbnailAttribute()
    {
        if ($this->has_thumbnail) {
            return 'https://storage.googleapis.com/aengzi.com/users/'.$this->getKey().'/origin.jpg';
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
