<h3>{{ $film->film_name }} - {{ $film->rating }}</h3>

<img src='/public/images/posters/<? echo $film->poster ?>' width=230px height=auto>

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
@endauth
