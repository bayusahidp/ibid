<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Jenssegers\Mongodb\Eloquent\Model;


class User extends Model implements JWTSubject, AuthenticatableContract
{
    use Authenticatable;
    use SoftDeletes;

    protected $connection = 'mongodb';

    protected $table = 'user';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'job', 'level'
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    // Has Many Function

    public function salary()
    {
        return $this->hasMany(Salary::class, 'user_id');
    }

    // End Has Many Function
}