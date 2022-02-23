<?php

namespace App\Http\Controllers\User\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Posts\Post;
use App\Models\Users\User;
use App\Models\Posts\PostComment;
use App\Models\Posts\PostCommentfavorite;
use Auth;

class PostCommentFavoritesController extends Controller
{
  public function commentfavorite(Request $request){
    $user_id = Auth::user()->id;
    $post_comment_id = $request->post_comment_id;
    $already_favorited = PostCommentFavorite::where('user_id', $user_id)->where('post_comment_id', $post_comment_id)->first();

    if (!$already_favorited) {
        $post_comment_favorites = new PostCommentFavorite;
        $post_comment_favorites->user_id = $user_id;
        $post_comment_favorites->post_comment_id = $post_comment_id;
        $post_comment_favorites->save();
      } else {
        PostCommentFavorite::where('post_comment_id', $post_comment_id)->where('user_id', $user_id)->delete();
      }

      $comment_favorite_count = PostComment::withCount('commentfavorite')->findOrFail($post_comment_id)->commentfavorite_count;
      $param = [
        'comment_favorite_count' => $comment_favorite_count,
      ];
      return response()->json($param);
    }
}
