<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
      'username',
      'email',
        'password',
        'email_verified_at'
    ];

    protected $guarded = [
      'remember_token'
    ];

    public function commentLikes()
    {
        return $this->belongsToMany(Post::class,'comment_likes','user_id','comment_id');
    }

    public function comments()
    {
        return $this->belongsToMany(Post::class, 'comments','user_id','post_id')->withPivot('desc');
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class,'likes','user_id','post_id');
    }




}
