<h1>Пользователь - {{ auth()->user()->login }}</h1>

<a href="{{ route('profile', ['action' => 'films']) }}">Список просмотренного</a>
<br>
<a href="{{ route('profile', ['action' => 'list']) }}">Заплонировано к просмотру</a>
<br>
<a href="{{ route('profile', ['action' => 'likes']) }}">Любимые фильмы</a>

@if($action != '')
  @extends('layouts.echo-films')
  @section('links')
    <a href="{{ route('profile', ['action' => $action, 'page' => $prev]) }}">prev</a>|
    <a href="{{ route('profile', ['action' => $action, 'page' => $next]) }}">next</a>
  @endsection
@endif
