<?php

namespace App\Http\Controllers\User\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Posts\Post;
use App\Models\Users\User;
use App\Models\Posts\Postfavorite;
use Auth;

class PostFavoritesController extends Controller
{
    public function postfavorite(Request $request){
      $user_id = Auth::user()->id;
      $post_id = $request->post_id;
      $already_favorited = PostFavorite::where('user_id', $user_id)->where('post_id', $post_id)->first();

      if (!$already_favorited) {
          $post_favorites = new PostFavorite;
          $post_favorites->user_id = $user_id;
          $post_favorites->post_id = $post_id;
          $post_favorites->save();
        } else {
          PostFavorite::where('post_id', $post_id)->where('user_id', $user_id)->delete();
        }

        $post_favorite_count = Post::withCount('postfavorite')->findOrFail($post_id)->postfavorite_count;
        $param = [
          'post_favorite_count' => $post_favorite_count,
        ];
        return response()->json($param);
      }
}
