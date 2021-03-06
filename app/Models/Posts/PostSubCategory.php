<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostSubCategory extends Model
{
    use SoftDeletes;

    protected $table = 'post_sub_categories';

    protected $fillable = [
        'post_main_category_id',
        'sub_category',
    ];

    public function posts(){
        return $this->hasMany('App\Models\Posts\Post');
    }

    public function postMainCategories(){
      return $this->belongsTo('App\Models\Posts\PostMainCategory');
    }

    public function getLists(){
      $subcategories = PostSubCategory::pluck('id', 'sub_category');

      return $subcategories;
    }
}
