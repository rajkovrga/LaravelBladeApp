<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
      'title',
      'desc'
    ];

    public function comments()
    {
        return $this->belongsToMany(User::class,'comments','post_id','user_id')->as('comment')->withPivot('desc');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class,'likes','post_id','user_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

}
