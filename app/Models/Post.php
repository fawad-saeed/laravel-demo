<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['body'];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
