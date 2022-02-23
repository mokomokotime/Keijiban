$(function () {
  let favorite = $('.favorite-toggle');
  let FavoritePostid;
  favorite.on('click', function () {
    let $this = $(this);
    FavoritePostid = $this.data('post-id');

    $.ajax({
      headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },
      url: '/favorite',
      method: 'POST',
      data: {
        'post_id': FavoritePostid
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
      $this.next('.post-favorite-counter').html(data.post_favorite_count);
    })

    .fail(function () {
      console.log('fail');
    });
  });
  });
