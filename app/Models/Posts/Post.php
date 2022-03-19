<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'post_sub_category_id',
        'delete_user_id',
        'update_user_id',
        'title',
        'post',
        'event_at',
    ];

    public function user(){
      return $this->belongsTo('App\Models\Users\User');
    }

    public function comments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function SubCategory(){
       return $this->belongTo('App\Models\Posts\PostSubCategory');
    }

    public function postfavorite(){
      return $this->hasMany('App\Models\Posts\PostFavorite');
    }

    //いいねを判定するメソッド
    public function isfavoritedBy($user): bool{
        return PostFavorite::where('user_id', $user->id)->where('post_id', $this->id)->first() !==null;
    }

    //検索
    public function scopeSearch($query, $searchword){
      return $query->where(function($query) use($searchword){
             $query->orWhere('title', 'like', "%{$searchword}%")
                   ->orWhere('post', 'like', "%{$searchword}%");
                 });
    }
}
