$(function () {
  let commentfavorite = $('.favorite-toggle');
  let FavoritePostCommentid;
  commentfavorite.on('click', function () {
    let $this = $(this);
    FavoritePostCommentid = $this.data('comment-id');

    $.ajax({
      headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },
      url: '/commentfavorite',
      method: 'POST',
      data: {
        'post_comment_id': FavoritePostCommentid
      },
    })

    .done(function (data) {
      if($this.hasClass('favorited')){
        $this.removeClass('favorited');
        $this.removeClass('fas');
        $this.addClass('far');
      }else{
        $this.addClass('favorited');
        $this.removeClass('far');
        $this.addClass('fas');
      }
      $this.next('.comment-favorite-counter').html(data.comment_favorite_count);
    })

    .fail(function () {
      console.log('fail');
    });
  });
  });
