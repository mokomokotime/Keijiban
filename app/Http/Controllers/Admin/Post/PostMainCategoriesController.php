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

class PostMainCategoriesController extends Controller
{
  public function categoryindex(){
    $postMainCategories = PostMainCategory::with('postSubCategories')->get();
    $main_categories = DB::table('post_main_categories')
      ->select('post_main_categories.id', 'post_main_categories.main_category')
      ->whereNull('post_main_categories.deleted_at')
      ->get();

      return view('posts.category', [
        'postMainCategories' => $postMainCategories,
        'main_categories' => $main_categories,
      ]);
  }

  public function newmaincategory(Request $request){
    $validator = Validator::make($request->all(),[
      'newmaincategory' => 'required|string|max:100|unique:post_main_categories,main_category',
    ]);

    $validator->validate();

    $main_categories = new PostMainCategory;
    $main_categories->main_category = $request->newmaincategory;
    $main_categories->save();

    return redirect('/category');
  }

  public function maincategorydelete(Request $request){
    $main_category = PostMainCategory::find($request->maincategoryid);
    $main_category->delete();

    return redirect('/category');
  }
}
