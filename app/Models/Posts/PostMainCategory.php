<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostMainCategory extends Model
{
    protected $table = 'post_main_categories';

    protected $fillable = [
        'main_category',
    ];

    public function posts(){
        return $this->hasMany('App\Models\Posts\Post');
    }

    public function postSubCategories(){
      return $this->belongsTo('App\Models\Posts\PostSubCategory');
    }
}
