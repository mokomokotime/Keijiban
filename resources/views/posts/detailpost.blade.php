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
    <p>掲示板詳細画面</p>
    <p><a href="/logout">ログアウト</a></p>
    <p>{{ $post->user->username }}さん</p>
    <p>{{ $post->created_at }}</p>
    <p>{{ $post->title }}</p>
    <p>{{ $post->post }}</p>
    <p>○○View</p>
    <p>コメント数：{{ $comments->count() }}</p>
    @if (!$post_fav->isfavoritedBy(Auth::user()))
      <span class="favorites">
          <i class="far fa-heart favorite-toggle" data-post-id="{{ $post->id }}"></i>
        <span class="post-favorite-counter">{{ $post_fav->postfavorite_count }}</span>
      </span>
    @else
      <span class="favorites">
          <i class="fas fa-heart favorited favorite-toggle" data-post-id="{{ $post->id }}"></i>
        <span class="post-favorite-counter">{{ $post_fav->postfavorite_count }}</span>
      </span>
    @endif
    @if( $post->user_id === Auth::user()->id )
      <a href="/{{ $post->id }}/{{ $post->user_id }}/post/edit">編集</a>
    @endif
    @foreach($post->comments as $comment)
      <p>コメント</p>
      <p>{{ $comment->user->username }}さん</p>
      <p>{{ $comment->created_at }}</p>
      @if( $comment->user_id === Auth::user()->id )
        <a href="/{{ $comment->id }}/{{ $comment->user_id }}/comment/edit">編集</a>
      @endif
      <p>{{ $comment->comment }}</p>
      @if (!$comment_fav->isfavoritedBy(Auth::user()))
        <span class="comment-favorites">
            <i class="far fa-heart favorite-toggle" data-comment-id="{{ $comment->id }}"></i>
          <span class="comment-favorite-counter">{{ $comment_fav->commentfavorite_count }}</span>
        </span>
      @else
        <span class="comment-favorites">
            <i class="fas fa-heart favorited favorite-toggle" data-comment-id="{{ $comment->id }}"></i>
          <span class="comment-favorite-counter">{{ $comment_fav->commentfavorite_count }}</span>
        </span>
      @endif
    @endforeach

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('post.newcomment') }}" method="post">
    @csrf
      <textarea name="comment" rows="8" cols="80" placeholder="コチラからコメントできます"></textarea>
      <input type="hidden" name="hiddenuserid" value="{{ Auth::user()->id }}">
      <input type="hidden" name="hiddenpostid" value="{{ $post->id }}">
      <input type="submit" name="commentbtn" value="コメント">
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/_ajaxcommentfavorite.js') }}"></script>
  </body>
</html>
