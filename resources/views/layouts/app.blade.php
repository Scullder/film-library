<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <script src="{{ URL::asset('js/jquery.js') }}" /></script>
    <script>

    $(document).ready(function(){
      $("#comment-send").on("click", function(){
        $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
          url: "/public/ajax/add",
          method: "post",
          data: { comment: $("#comment").val(),
                  film_id: $("#film_id").text()},
          success: function(response){
            $('#comment').val('');
            if(response != false)
            {
              response = JSON.parse(response);
              append_comment(response.token, response.review);
            }
          }
        })
      });
    })

    function append_comment(token, review)
    {
      $('#comments-list').append('<div class="loaded-comments" id="' + token + '">' + review + '</div>');
    }

    function load_comment()
    {
      var comm_loaded = $('.loaded-comments');
      var comm_tokens = [];

      comm_loaded.each(function(){
        comm_tokens.push($(this).attr('id'));
      });

      $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      $.ajax({
        url: "/public/ajax/load",
        method: "post",
        data: { 'tokens': comm_tokens,
                film_id: $("#film_id").text()},
        success:  function(response){
          if(response != false)
          {
            response = JSON.parse(response);
            for(var token in response)
              append_comment(token, response[token]);
          }
        }
      })
    }

    $(document).ready(function(){
        setInterval(load_comment, 5000);
        //load_comment();
    })


    </script>
  </head>
  <body>
    @yield('body')
  </body>
</html>
