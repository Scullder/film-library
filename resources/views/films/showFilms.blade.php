@extends('layouts.echo-films')
@section('links')
  <a href="{{ route('films', ['page' => $prev])}}">prev</a>
  <a href="{{ route('films', ['page' => $next])}}">next</a>
@endsection
