<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\UserFilms;
use App\Models\Watchlist;
use App\Models\User;

class UserController extends Controller
{
  public function Like(Request $request)
  {
    $login = Auth::user()->login;
    $model = new UserFilms();
    if($request->watch == false)
      $this->InsertOrDelete($login, $request->id, $model, $request->watch);
    $model->where([['login', '=', "$login"], ['film_id', '=', $request->id]])->update(['liked' => !$request->like]);
    return redirect()->back();
  }

  public function Watch(Request $request)
  {
    $login = Auth::user()->login;
    $action = $this->InsertOrDelete($login, $request->id, new UserFilms(), $request->watch);
    $inlist = $this->CheckWatchlist($request->id, $login);

    // если фильм был просмотрен удаление из списка
    if($action == true && $inlist == true)
      $action = $this->InsertOrDelete($login, $request->id, new Watchlist());

    return redirect()->back();
  }

  public function List(Request $request)
  {
    $login = Auth::user()->login;
    $model = new Watchlist();
    $this->InsertOrDelete($login, $request->id, $model, $request->inlist);
    return redirect()->back();
  }

  private function InsertOrDelete($login, $id, $model, $atribute = true)
  {
    if($atribute != true)
    {
      $model->login = $login;
      $model->film_id = $id;
      $model->save();
      // если был добавлен
      return true;
    }
    else
    {
      $model->where([['login', '=', $login], ['film_id', '=', $id]])->delete();
      // если был удалён
      return false;
    }
  }

  public function CheckLike($id, $login = '')
  {
    $liked = UserFilms::where([ ['login', '=', $login], ['film_id', '=', $id, 'and'],['liked', '=', 1, 'and']])->first();
    return $liked != null;
  }

  public function CheckWatch($id, $login = '')
  {
    $watched = UserFilms::where([['login', '=', $login], ['film_id', '=', $id, 'and']])->first();
    return $watched != null;
  }

  public function CheckWatchlist($id, $login = '')
  {
    $inlist = Watchlist::where([['login', '=', $login], ['film_id', '=', $id]])->first();
    return $inlist != null;
  }

  public function rating(Request $request)
  {
    $login = Auth::user()->login;
    $isset = DB::select('select count(login) as isset from `userrating` where login = ? and film_id = ?', ["$login", $request->id]);
    if($isset[0]->isset != 0)
      DB::update('update `userrating` set rate = ? where login = ? and film_id = ?', [$request->userRate, "$login", $request->id]);
    else
      DB::insert('insert into `userrating`(login, film_id, rate) values(?, ?, ?)', ["$login", $request->id, $request->userRate]);
    $result = DB::select('select sum(rate) as sum, count(rate) as count from `userrating` where film_id = ?', [$request->id]);
    $sum = $result[0]->sum;
    $count = $result[0]->count;
    $newRating = round(($sum / $count), 1);
    DB::update('update `films` set rating = ? where id = ?', [$newRating, $request->id]);
    return redirect()->back();
  }
}
