<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p>掲示板投稿機能</p>
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
    <form action="/post/update" method="post">
    @csrf
      <dl>
        <dt>サブカテゴリー</dt>
        <dd><input type="text" name="subcategory" value="ここはあとで入れます。"></dd>
        <dt>タイトル</dt>
        <dd><input type="text" name="posttitle" value="{{ $post->title }}"></dd>
        <dt>投稿内容</dt>
        <input type="text" name="posttext" size="150" value="{{ $post->post }}"></textarea>
      </dl>
      <input type="submit" name="updatebtn" value="更新">
      <input type="hidden" name="postid" value="{{ $post->id }}">
      <input type="hidden" name="userid" value="{{ $post->user_id }}">
    </form>
    <form action="/post/delete" method="post">
    @csrf
      <input type="submit" name="deletebtn" value="削除">
      <input type="hidden" name="postid" value="{{ $post->id }}">
      <input type="hidden" name="userid" value="{{ $post->user_id }}">
    </form>
  </body>
</html>
