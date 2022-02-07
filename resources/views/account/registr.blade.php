@extends('layouts.app')
@section('title', 'Вход')

@section('body')
  @if ($errors->any())
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
  @endif

  <form action="{{ route('registr') }}" method="post">
    @csrf
    <input type="text" name="login" value="{{ old('login') }}" placeholder="логин" autocomplete="off" ><br>
    <input type="email" name="email" value="{{ old('email') }}" placeholder="почта" autocomplete="off"><br>
    <input type="password" name="password" value="{{ old('password') }}" placeholder="пароль" autocomplete="off" ><br>
    <input type="password" name="passwordConfirm" value="{{ old('passwordConfirm') }}" placeholder="подтвердить пароль" autocomplete="off" ><br>

    <input type="submit" value="создать аккаунт"><br>
  </form>

  <a href="{{ route('loginView') }}">есть аккаунт?</a>
@endsection
