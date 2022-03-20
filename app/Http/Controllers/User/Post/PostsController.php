<?php

namespace App\Http\Controllers\User\Post;

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
use Carbon\Carbon;

class PostsController extends Controller
{
  public function index(Request $request){
      $user_id = Auth::id();
      $users_posts = DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->join('post_sub_categories', 'post_sub_categories.id', '=', 'posts.post_sub_category_id')
        ->select('users.username', 'posts.post', 'posts.id', 'posts.user_id', 'posts.created_at', 'posts.title', 'post_sub_categories.sub_category')
        ->latest()
        ->whereNull('posts.deleted_at')
        ->get();
      $searchword = $request->input('searchword');

      $post = Post::withCount('postfavorite')->orderBy('id', 'desc')->first();
      $comments = DB::table('post_comments')->select('comment')->get();
      $param = [
        'post' => $post,
      ];

      //アクセスカウンター
      if(session()->has('count')){
          $count = session('count');
      }else{
          $count = 0;
      }
      $count++;
      session(['count' => "$count"]);

      return view('posts.index', [
        'users_posts' => $users_posts, $param, 'count' => $count,
        'post' => $post, 'comments' => $comments, 'searchword' => $searchword,
      ]);
  }

  public function newpost(){
    $sub_categories = DB::table('post_sub_categories')
      ->select('post_sub_categories.id', 'post_sub_categories.sub_category')
      ->get();

    return view('posts.newpost', ['sub_categories' => $sub_categories]);
  }

  public function store(Request $request){
      $validator = Validator::make($request->all(),[
        'posttitle' => 'required|string|max:100',
        'postcontent'  => 'required|string|max:5000',
      ]);

      if($validator->fails()){
        return redirect('/post')
        ->withErrors($validator)
        ->withInput();
      }

      $posts = new Post;
      $date = Carbon::now();
      $posts->post_sub_category_id = $request->selectsubcategorybtn;
      $posts->post = $request->postcontent;
      $posts->title = $request->posttitle;
      $posts->event_at = $date->format('Y-m-d');
      $posts->user_id = Auth::id();
      $posts->save();

      return redirect('/top');
  }

  public function mypost(Request $request){
    $user_id = Auth::id();
    $users_posts = DB::table('posts')
      ->join('users', 'users.id', '=', 'posts.user_id')
      ->join('post_sub_categories', 'post_sub_categories.id', '=', 'posts.post_sub_category_id')
      ->where('user_id', $user_id)
      ->select('users.username', 'posts.post', 'posts.id', 'posts.user_id', 'posts.created_at', 'posts.title', 'post_sub_categories.sub_category')
      ->latest()
      ->whereNull('posts.deleted_at')
      ->get();

    $post = Post::withCount('postfavorite')->orderBy('id', 'desc')->first();
    $param = [
      'post' => $post,
    ];
    $searchword = $request->input('searchword');
    $comments = DB::table('post_comments')->select('comment')->get();

    //アクセスカウンター
    if(session()->has('count')){
        $count = session('count');
    }else{
        $count = 0;
    }
    $count++;
    session(['count' => "$count"]);

    return view('posts.index', [
      'users_posts' => $users_posts, 'comments' => $comments, 'count' => $count,
      $param, 'post' => $post, 'searchword' => $searchword,
    ]);
  }

  public function favoritepost(Request $request){
    $user = Auth::user();
    $users_posts = PostFavorite::with(['post', 'post.user'])
        ->where('user_id', $user->id)
        ->get();

    $post = Post::withCount('postfavorite')->orderBy('id', 'desc')->first();
    $param = [
      'post' => $post,
    ];
    $searchword = $request->input('searchword');
    $comments = DB::table('post_comments')->select('comment')->get();

    //アクセスカウンター
    if(session()->has('count')){
        $count = session('count');
    }else{
        $count = 0;
    }
    $count++;
    session(['count' => "$count"]);


    return view('posts.favoritepost', [
      'users_posts' => $users_posts, 'comments' => $comments, 'count' => $count,
      $param, 'post' => $post, 'searchword' => $searchword,
    ]);
  }

  public function detailpost(Request $request, $id){
    $user = auth()->user();
    $post = Post::findOrFail($id);

    $comment_fav = PostComment::withCount('commentfavorite')->orderBy('id', 'desc')->first();
    $post_fav = Post::withCount('postfavorite')->orderBy('id', 'desc')->first();
    $comments = DB::table('post_comments')->select('comment')->get();
    $param = [
      'comment_fav' => $comment_fav,
    ];

    //アクセスカウンター
    if(session()->has('count')){
        $count = session('count');
    }else{
        $count = 0;
    }
    $count++;
    session(['count' => "$count"]);

    return view('posts.detailpost', [
        'post' => $post, 'post_fav' => $post_fav, 'count' => $count,
        'user' => $user, 'comments' => $comments,
        $param, 'comment_fav' => $comment_fav,
    ]);
  }

  public function edit($id){
    $post = Post::findOrFail($id);
    return view('posts.edit', ['post' => $post]);
  }

  public function postupdate(Request $request){
    $validator = Validator::make($request->all(),[
      'posttitle' => 'required|string|max:100',
      'posttext'  => 'required|string|max:5000',
    ]);

    $validator->validate();

    $post = Post::find($request->postid);
    $post->update([
      'post' => $request->posttext,
      'title' => $request->posttitle,
      'update_user_id' => $request->userid,
    ]);

    return redirect(route('post.detailpost', [$post->id]));
  }

  public function postdelete(Request $request){
    $post = Post::find($request->postid);
    $post->update([
      'delete_user_id' => $request->userid,
    ]);

    $post->delete();

    return redirect('/top');
  }

  public function search(Request $request){
    $searchword = $request->input('searchword');

    if(!empty($searchword)){
    $result = Post::where('title', 'like', '%' . $searchword . '%')
      ->orWhere('post', 'like', '%' . $searchword . '%')
      ->orWhereHas('SubCategory', function($query) use ($searchword){
          $query->where('sub_category', $searchword);
      })
      ->get();
    } else {
      return redirect('/');
    }

    $users_posts = $result->orderBy('created_at', 'desc')->get();

    $post = Post::withCount('postfavorite')->orderBy('id', 'desc')->first();
    $comments = DB::table('post_comments')->select('comment')->get();
    $param = [
      'post' => $post,
    ];

    return view('posts.index', [
      'searchword' => $searchword, 'users_posts' => $users_posts,
      $param, 'post' => $post, 'comments' => $comments,
    ]);
  }

  public static function escapeLike($str){
      return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
  }

  public function categoryindex(){
    $postMainCategories = PostMainCategory::with('postSubCategories')->get();
    $main_categories = DB::table('post_main_categories')
      ->select('post_main_categories.id', 'post_main_categories.main_category')
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
}
