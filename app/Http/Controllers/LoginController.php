<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    public function login(Request $request)
    {
      $credentials = ['login' => $request->login, 'password' => $request->password];
      if(Auth::attempt($credentials))
      {
        $request->session()->regenerate();
        return redirect()->route('films');
      }

      return redirect()->back();
    }

    public function logout(Request $request)
    {
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect()->route('films');
    }

    public function registr(Request $request)
    {
      $request->validate([
        'login' => ['required'],
        'email' => ['email'],
        'password' => ['required', 'min:5'],
        'passwordConfirm' => ['required', 'min:5']
      ]);
    }
}
