<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p>ユーザー登録</p>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('user.register') }}" method="post">
    @csrf
      <label>ユーザー名</label>
      <input type="text" name="username">
      <label>メールアドレス</label>
      <input type="text" name="email">
      <label>パスワード</label>
      <input type="password" name="password">
      <label>パスワード確認</label>
      <input type="password" name="password_confirmation">
      <input type="submit" name="register" value="確認">
    </form>
  </body>
</html>
