<?php

namespace App\Http\Controllers\User\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Posts\Post;
use App\Models\Users\User;
use App\Models\Posts\PostComment;
use App\Models\Posts\PostCommentfavorite;
use App\Models\Posts\Postfavorite;
use Auth;
use Carbon\Carbon;

class PostsController extends Controller
{
  public function index(){
      $user_id = Auth::id();
      $users_posts = DB::table('users')
        ->join('posts', 'users.id', '=', 'posts.user_id')
        ->select('users.username', 'posts.post', 'posts.id', 'posts.user_id', 'posts.created_at', 'posts.title')
        ->latest()
        ->whereNull('posts.deleted_at')
        ->get();

      $post = Post::withCount('postfavorite')->orderBy('id', 'desc')->first();
      $param = [
        'post' => $post,
      ];

      return view('posts.index', [
        'users_posts' => $users_posts, $param,
        'post' => $post,
      ]);
  }

  public function newpost(){
    return view('posts.newpost');
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
      $posts->post = $request->postcontent;
      $posts->title = $request->posttitle;
      $posts->event_at = $date->format('Y-m-d');
      $posts->user_id = Auth::id();
      $posts->save();

      return redirect('/top');
  }

  public function mypost(){
    $user_id = Auth::id();
    $users_posts = DB::table('users')
      ->join('posts', 'users.id', '=', 'posts.user_id')
      ->where('user_id', $user_id)
      ->select('users.username', 'posts.post', 'posts.id', 'posts.user_id', 'posts.created_at', 'posts.title')
      ->latest()
      ->whereNull('posts.deleted_at')
      ->get();

    $post = Post::withCount('postfavorite')->orderBy('id', 'desc')->first();
    $param = [
      'post' => $post,
    ];

    return view('posts.index', [
      'users_posts' => $users_posts,
      $param, 'post' => $post
    ]);
  }

  public function favoritepost(){
    $user_id = Auth::id();
    $users_posts = DB::table('posts')
      ->join('post_favorites', 'posts.id', '=', 'post_favorites.user_id')
      ->join('users', 'posts.id', '=', 'users.id')
      ->where('post_favorites.user_id', $user_id)
      ->select('users.username', 'posts.post', 'posts.id', 'posts.user_id', 'posts.created_at', 'posts.title', 'post_favorites.user_id', 'post_favorites.post_id')
      ->latest()
      ->whereNull('posts.deleted_at')
      ->whereNull('post_favorites.deleted_at')
      ->get();

    $post = Post::withCount('postfavorite')->orderBy('id', 'desc')->first();
    $param = [
      'post' => $post,
    ];

    return view('posts.index', [
      'users_posts' => $users_posts,
      $param, 'post' => $post
    ]);
  }

  public function detailpost(Request $request, $id){
    $user = auth()->user();
    $post = Post::findOrFail($id);

    $comment_fav = PostComment::withCount('commentfavorite')->orderBy('id', 'desc')->first();
    $param = [
      'comment_fav' => $comment_fav,
    ];

    return view('posts.detailpost', [
        'post' => $post,
        'user' => $user,
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
}
