<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostMainCategory extends Model
{
    use SoftDeletes;
    
    protected $table = 'post_main_categories';

    protected $fillable = [
        'main_category',
    ];

    public function postSubCategories(){
      return $this->hasMany('App\Models\Posts\PostSubCategory');
    }
}
