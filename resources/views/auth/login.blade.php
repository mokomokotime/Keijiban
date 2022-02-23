<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ログイン</title>
  </head>
  <body>
    <p>ログイン</p>
    <form action="{{ route('user.login') }}" method="post">
    @csrf
      <label>メールアドレス</label>
      <input type="text" name="email">
      <label>パスワード</label>
      <input type="password" name="password">
      <input type="submit" name="login" value="ログイン">
    </form>
    <p>新規ユーザー登録は<a href="/register">こちら</a></p>
  </body>
</html>
