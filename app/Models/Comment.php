<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id'];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
