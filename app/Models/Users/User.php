<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'admin_role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function posts(){
      return $this->hasMany('App\Models\Posts\Post');
    }

    public function comments(){
      return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function postfavorite(){
      return $this->hasMany('App\Models\Posts\PostFavorite');
    }

    public function commentfavorite(){
      return $this->hasMany('App\Models\Posts\PostCommentFavorite');
    }
}
