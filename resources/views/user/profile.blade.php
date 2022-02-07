@extends('layouts.app')
@section('title', 'Profile/' . auth()->user()->login)

@section('body')
  <h1>Пользователь - {{ auth()->user()->login }}</h1>

  <a href="{{ route('profile', ['action' => 'films']) }}">Список просмотренного</a>
  <br>
  <a href="{{ route('profile', ['action' => 'list']) }}">Заплонировано к просмотру</a>
  <br>
  <a href="{{ route('profile', ['action' => 'likes']) }}">Любимые фильмы</a>

  @if($action != '')
    @include('layouts.echo-films', ['prev' => $prev, 'next' => $next])
  @endif
@endsection
