<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p>コメント編集画面</p>
    <p><a href="/logout">ログアウト</a></p>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="/comment/update" method="post">
    @csrf
      <dl>
        <dt>コメント</dt>
        <input type="text" name="commenttext" size="150" value="{{ $comment->comment }}"></textarea>
      </dl>
      <input type="submit" name="updatebtn" value="更新">
      <input type="hidden" name="commentid" value="{{ $comment->id }}">
      <input type="hidden" name="userid" value="{{ $comment->user_id }}">
    </form>
    <form action="/comment/delete" method="post">
    @csrf
      <input type="submit" name="deletebtn" value="削除">
      <input type="hidden" name="commentid" value="{{ $comment->id }}">
      <input type="hidden" name="userid" value="{{ $comment->user_id }}">
    </form>
  </body>
</html>
