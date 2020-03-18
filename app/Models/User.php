<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\Authenticatable as Auth;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Authenticatable implements Auth
{
    use Notifiable;
    use HasRoles;
    use AuthenticableTrait;

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
