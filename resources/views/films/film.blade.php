@extends('layouts.app')
@section('title', $film->film_name)


@section('body')
  <h3>{{ $film->film_name }} - {{ $film->rating }}</h3>
  <img src='/public/images/posters/<? echo $film->poster ?>' width=230px height=auto>
  <div id="film_id">{{ $film->id }}</div>
  @auth
    <?
      $likeButton = ($like == true) ? 'удалить из лайков' : 'лайк';
      $watchButton = ($watch == true) ? 'удалить из просмотров' : 'просмотрено';
      $watchlistButton = ($inlist == true) ? 'удалить из списка' : 'добавить в список';
    ?>

    <form action="{{ route('filmList') }}" method="post">
      @csrf
      <input type="text" name="id" value="<? echo $film->id ?>" hidden>
      <input type="text" name="inlist" value="<? echo $inlist ?>" hidden>

      <button type="submit">{{ $watchlistButton }}</button>
    </form>


    <form action="{{ route('filmWatch') }}" method="post">
      @csrf
      <input type="text" name="id" value="<? echo $film->id ?>" hidden>
      <input type="text" name="watch" value="<? echo $watch ?>" hidden>

      <button type="submit">{{ $watchButton }}</button>
    </form>


    <form action="{{ route('filmLike') }}" method="post">
      @csrf
      <input type="text" name="id" value="<? echo $film->id ?>" hidden>
      <input type="text" name="like" value="<? echo $like ?>" hidden>
      <input type="text" name="watch" value="<? echo $watch ?>" hidden>

      <button type="submit">{{ $likeButton }}</button>
    </form>

    <form action="{{ route('newRate') }}" method="post">
      @csrf
      <input type="text" name="userRate" placeholder="ваша оценка">
      <input type="text" name="id" value="<? echo $film->id ?>" hidden>
      <input type="text" name="rating" value="<? echo $film->rating ?>" hidden>

      <button type="submit">поставить оценку</button>
    </form>

    <div id="comments-section">

      <div id="comments-add">
        <textarea id="comment" type="text"></textarea><br>
        <button id="comment-send" type="submit">Отправить</button>
      </div>

    </div>
  @endauth

  <div id="comments-list">
    @if($film->reviews !== '')
    
      @foreach($reviews as $review)
        <div class="loaded-comments" id="{{$review->review_token}}">
          {{ $review->review }}
        </div>
      @endforeach

    @endif
  </div>

@endsection
