<?php

namespace App\Http\Controllers\User\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Posts\Post;
use App\Models\Users\User;
use App\Models\Posts\PostComment;
use Carbon\Carbon;

class PostCommentsController extends Controller
{
    public function commentstore(Request $request){
      $validator = Validator::make($request->all(),[
        'comment' => 'required|string|max:2500',
      ]);

      $validator->validate();

      $post_comments = new PostComment;
      $date = Carbon::now();
      $post_comments->comment = $request->comment;
      $post_comments->user_id = $request->hiddenuserid;
      $post_comments->post_id = $request->hiddenpostid;
      $post_comments->event_at = $date->format('Y-m-d');
      $post_comments->save();

      return back();
    }

    public function commentedit($id){
      $comment = PostComment::findOrFail($id);
      return view('posts.commentedit', ['comment' => $comment]);
    }

    public function commentupdate(Request $request){
      $validator = Validator::make($request->all(),[
        'commenttext'  => 'required|string|max:2500',
      ]);

      $validator->validate();

      $comment = PostComment::find($request->commentid);
      $comment->update([
        'comment' => $request->commenttext,
        'update_user_id' => $request->userid,
      ]);

      return redirect(route('post.detailpost', [$comment->post_id]));
    }

    public function commentdelete(Request $request){
      $comment = PostComment::find($request->commentid);
      $comment->update([
        'delete_user_id' => $request->userid,
      ]);

      $comment->delete();

      return redirect('/top');
    }
}
