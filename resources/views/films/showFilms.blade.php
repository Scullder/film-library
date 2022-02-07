@extends('layouts.app')
@section('title', 'Фильмы')
@section('body')
  @include('layouts.echo-films', ['prev' => $prev, 'next' => $next])
@endsection
