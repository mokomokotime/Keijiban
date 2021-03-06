<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p>新規投稿画面</p>
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
    <form action="{{ route('post.newpost') }}" method="post">
    @csrf
      <label>サブカテゴリー</laberl>
      <select class="form-subcategory" name="selectsubcategorybtn">
        @foreach($sub_categories as $sub_category)
          <option name="selectsubcategory" value="{{ $sub_category->id }}">{{ $sub_category->sub_category }}</option>
        @endforeach
      </select>
      <label>タイトル</label>
      <input type="text" name="posttitle">
      <label>投稿内容</label>
      <textarea name="postcontent" rows="8" cols="80"></textarea>
      <input type="submit" name="postbtn" value="投稿">
    </form>
  </body>
</html>
