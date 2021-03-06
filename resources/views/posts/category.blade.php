<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>カテゴリー追加画面</title>
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
    <form action="/newmaincategory" method="post">
    @csrf
      <input type="text" name="newmaincategory">
      <input type="submit" name="maincategorybtn" value="登録">
    </form>
    <form action="/newsubcategory" method="post">
    @csrf
      <label>メインカテゴリー</label>
      <select class="form-maincategory" name="selectmaincategorybtn">
        @foreach($main_categories as $main_category)
          <option name="selectmaincategory" value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
        @endforeach
      </select>
      <label>新規サブカテゴリー</label>
      <input type="text" name="newsubcategory">
      <input type="submit" name="subcategorybtn" value="登録">
    </form>

    <p>カテゴリー一覧</p>
    @foreach($postMainCategories as $postMainCategory)
      <p>{{ $postMainCategory->main_category }}</p>
      @if($postMainCategory->postSubCategories->isEmpty())
        <form action="/maincategory/delete" method="post">
        @csrf
          <input type="submit" name="maincategorydeletebtn" value="削除">
          <input type="hidden" name="maincategoryid" value="{{ $postMainCategory->id }}">
        </form>
      @endif
      @foreach($postMainCategory->postSubCategories as $postSubCategory)
        <p>{{ $postSubCategory->sub_category }}</p>
          @if($postSubCategory->posts->isEmpty())
            <form action="/subcategory/delete" method="post">
            @csrf
              <input type="submit" name="subcategorydeletebtn" value="削除">
              <input type="hidden" name="subcategoryid" value="{{ $postSubCategory->id }}">
            </form>
          @endif
      @endforeach
    @endforeach
  </body>
</html>
