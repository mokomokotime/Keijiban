<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
  </head>
  <body>
    <p>掲示板投稿機能</p>
    <p><a href="/logout">ログアウト</a></p>
    <p><a href="/category">カテゴリーを追加</a></p>
    <p><a href="/post">投稿</a></p>
    <form class="post-search" action="{{ route('name.search') }}" method="get">
      <input type="text" name="searchword" value="">
      <button type="button" name="button">検索</button>
    </form>
    <p><a href="/favoritepost">いいねした投稿</a></p>
    <p><a href="/mypost">自分の投稿</a>

    @foreach($users_posts as $user_post)
      <p>{{ $user_post->username }}さん</p>
      <p>{{ $user_post->created_at }}</p>
      <p>○○View</p>
      <p><a href="{{ $user_post->id }}/post">{{ $user_post->title }}</a></p>
      <p>コメント数：{{ $comments->count() }}</p>
      @if (!$post->isfavoritedBy(Auth::user()))
        <span class="favorites">
            <i class="far fa-heart favorite-toggle" data-post-id="{{ $user_post->id }}"></i>
          <span class="post-favorite-counter">{{ $post->postfavorite_count }}</span>
        </span>
      @else
        <span class="favorites">
            <i class="fas fa-heart favorited favorite-toggle" data-post-id="{{ $user_post->id }}"></i>
          <span class="post-favorite-counter">{{ $post->postfavorite_count }}</span>
        </span>
      @endif
    @endforeach
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/_ajaxpostfavorite.js') }}"></script>
  </body>
</html>
