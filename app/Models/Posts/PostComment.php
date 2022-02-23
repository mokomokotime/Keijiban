<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use SoftDeletes;

    protected $table = 'post_comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'delete_user_id',
        'update_user_id',
        'comment',
        'event_at',
    ];

    public function post(){
        return $this->belongsTo('App\Models\Posts\Post');
    }

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function commentfavorite(){
      return $this->hasMany('App\Models\Posts\PostCommentFavorite');
    }

    //いいねを判定するメソッド
    public function isfavoritedBy($user): bool{
        return PostCommentFavorite::where('user_id', $user->id)->where('post_comment_id', $this->id)->first() !==null;
    }
}
