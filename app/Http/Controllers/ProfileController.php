<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Facades\App\Http\Controllers\FilmsController;

use Illuminate\Support\Facades\Auth;

use App\Models\UserFilms;
use App\Models\Watchlist;
use App\Models\User;
use App\Models\FilmsModel;


class ProfileController extends Controller
{
  public function profile($action = '', $page = 1)
  {
    $login = Auth::user()->login;

    if($action != '')
    {
      // получение всех ID для выбора фильмов
      if($action == 'films')
        $ids = UserFilms::select('film_id')->where('login', '=', $login)->get();
      else if($action == 'list')
        $ids = Watchlist::select('film_id')->where('login', '=', $login)->get();
      else if($action == 'likes')
        $ids = UserFilms::select('film_id')->where('login', '=', $login)->where('liked', '=', 1)->get();

      $table = FilmsController::CreateTable(4, $page, $ids);

      return view('user.profile', [ 'action' => $action,
                                    'films' => $table->films,
                                    'prev' => $table->prev,
                                    'next' => $table->next,
                                    'rows' => $table->rows,
                                    'cols' => $table->cols]);
    }
    else
    {
      return view('user.profile', ['action' => $action]);
    }
  }

}
