require('./bootstrap');
$(document).ready(function(){
  $("#comment-send").on("click", function(){
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $.ajax({
      url: "/public/ajax/add",
      method: "post",
      data: { comment: $("#comment").val() },
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

function load_comment()
{
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });
  $.ajax({
    url: "/public/ajax/load",
    method: "post",
    data: { comments: $(".loaded-comments").attr('id') },
    success:  function(response){
      if(response != false)
      {
        append_comment(response);
      }
    }
  })
}

function append_comment(token, review)
{
  $('#comments-list').append('<div class="loaded-comments" id="' + token + '">' + review + '</div>');
}

$(document).ready(function(){
  $("#class").on("click", function(){
    load_comment();
  });
})
