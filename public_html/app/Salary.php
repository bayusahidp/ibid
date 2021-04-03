<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;

class Salary extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';

    protected $table = 'salary';

    protected $fillable = [
        'user_id', 'salary', 'date'
    ];


    // Belongs To Function

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    // End Belongs To Function

}