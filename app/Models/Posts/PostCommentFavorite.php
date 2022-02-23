<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCommentFavorite extends Model
{
    use SoftDeletes;

    protected $table = 'post_comment_favorites';

    protected $fillable = [
        'user_id',
        'post_comment_id',
    ];

    public function user(){
      return $this->belongsTo('App\Models\Users\User');
    }

    public function comment(){
      return $this->belongsTo('App\Models\Posts\PostComment');
    }
}
