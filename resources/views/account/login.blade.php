<form action="{{ route('login') }}" method="post">
  @csrf
  <input type='text' name='login' placeholder='логин' autocomplete='off' required><br>
  <input type='password' name='password' placeholder='пароль' autocomplete='off' required><br>

  <input type='submit' value='вход'><br>
</form>

<a href="{{ route('registrView') }}">первый раз?</a>

<form action="{{ route('logout') }}" method="post">
  @csrf
</form>
