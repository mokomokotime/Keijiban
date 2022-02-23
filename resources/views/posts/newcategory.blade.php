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
    <label>新規メインカテゴリー</label>
    <form action="" method="post">
    @csrf
      <input type="text" name="newmaincategory">
      <input type="submit" name="maincategorybtn" value="登録">
    </form>
    <form action="" method="post">
    @csrf
      <label>メインカテゴリー</label>
      <p>ここはあとで入れます。</p>
      <label>新規サブカテゴリー</label>
      <input type="text" name="newsubcategory">
      <input type="submit" name="subcategorybtn" value="登録">
    </form>
  </body>
</html>
