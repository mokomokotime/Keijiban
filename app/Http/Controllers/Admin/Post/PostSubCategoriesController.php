<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Posts\Post;
use App\Models\Users\User;
use App\Models\Posts\PostComment;
use App\Models\Posts\PostCommentfavorite;
use App\Models\Posts\Postfavorite;
use App\Models\Posts\PostMainCategory;
use App\Models\Posts\PostSubCategory;
use Auth;

class PostSubCategoriesController extends Controller
{
  public function newsubcategory(Request $request){
    $validator = Validator::make($request->all(),[
      'selectmaincategorybtn' => 'required|exists:post_main_categories,id',
      'newsubcategory' => 'required|string|max:100|unique:post_sub_categories,sub_category',
    ]);

    $validator->validate();

    $sub_categories = new PostSubCategory;
    $sub_categories->post_main_category_id = $request->selectmaincategorybtn;
    $sub_categories->sub_category = $request->newsubcategory;
    $sub_categories->save();

    return redirect('/category');
  }

  public function subcategorydelete(Request $request){
    $sub_category = PostSubCategory::find($request->subcategoryid);
    $sub_category->delete();

    return redirect('/category');
  }
}
