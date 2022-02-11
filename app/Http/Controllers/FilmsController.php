<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\FilmsModel;
use App\Http\Controllers\UserController;

class FilmsController extends Controller
{
  public function ShowFilms($page = 1)
  {
    $filmsTable = $this->CreateTable(20, $page);
    if($filmsTable->prev == 0)
      $filmsTable->prev = $page;
    return view('films.showFilms', ['films' => $filmsTable->films,
                                    'cols' => $filmsTable->cols,
                                    'rows' => $filmsTable->rows,
                                    'prev' => $filmsTable->prev,
                                    'next' => $filmsTable->next,
                                    'page' => $page]);
  }

  public function TakeFilm($filmUri)
  {
    $tokens = [ "02b18df88abb5f93dbad2e26150e9779",
                "2f1aa2b0d8095ab2a8b19ba7c9f0b078",
                "47d28488fc7d94c8c0f878466ceb2935",
                "b587b9122d42873b4989b366213b5a7e",
                "c7fcbb971c5e42665207c10041739bb8",
                "cd294a89bc2a03223ff642bc9ff44908"];
    $tokensString = implode(',', $tokens);
    echo $tokensString;
    $tokensSelected = DB::select('select login, review, review_token as token from reviews
                                where review_token not in(?) and film_id = ?', [$tokensString, 1]);

    $tokens = [];
    $reviews = [];
    foreach($tokensSelected as $obj)
    {
      $tokens[] = $obj->token;
      $reviews[] = $obj->review;
    }

    print_r(array_combine($tokens, $reviews));

    //$filmName = str_replace('-', ' ', $filmName);
    $film = FilmsModel::where('film_uri', '=', $filmUri)->first();
    $reviews = $this->SelectAllReviews($film->id);

    if(Auth::check())
    {
      $login = Auth::user()->login;
      $user = new UserController();
      $like = $user->CheckLike($film->id, $login);
      $watch = $user->CheckWatch($film->id, $login);
      $inlist = $user->CheckWatchlist($film->id, $login);

      return view('films.film', [ 'film' => $film,
                                  'like' => $like,
                                  'watch' => $watch,
                                  'reviews' => $reviews,
                                  'inlist' => $inlist]);
    }
    return view('films.film', ['film' => $film, 'reviews' => $reviews]);
  }

  private function SelectAllReviews($filmId)
  {
    $filmReviews = DB::select('select * from reviews where film_id = ?', [$filmId]);
    return $filmReviews;
  }

  public function CreateTable($filmsCount, $page, $filmsID = null)
  {
    // выбор фильмов по полученным ID или всех фильмов на страницу
    $limit = $filmsCount;
    $offset = $limit * ($page - 1);
    $allFilms = 0;
    if($filmsID == null)
    {
      $films = FilmsModel::offset($offset)->limit($limit)->get();
      $allFilms = FilmsModel::count('id');
    }
    else
    {
      $films_id = [];
      foreach($filmsID as $id)
        $films_id[] = $id->film_id;
      $films = FilmsModel::whereIn('id', $films_id)->offset($offset)->limit($limit)->get();
      $allFilms = count($films_id);
    }

    // расчёт след/пред. страниц
    $lastPage = ceil($allFilms / $limit);
    $prev = ($page > 1) ? $page - 1 : $page;
    $next = ($page < $lastPage) ? $page + 1 : $page;
    //$routeName = Route::currentRouteName();
    //$link = "<a href=" . route($routeName, ['action' => 'films', 'page' => 1]) . ">prev</a>";

    // расчёт колличества столбцов и строк
    if(count($films) > 6)
    {
      $colCount = ceil(sqrt(count($films)));
      $rowCount = ceil(count($films) / $colCount);
    }
    else
    {
      $colCount = count($films);
      $rowCount = 1;
    }

    return new class($films, $colCount, $rowCount, $prev, $next)
    {
      public $films;
      public $cols;
      public $rows;
      public $prev;
      public $next;

      public function __construct($films, $cols, $rows, $prev, $next)
      {
        $this->films = $films;
        $this->cols = $cols;
        $this->rows = $rows;
        $this->prev = $prev;
        $this->next = $next;
      }
    };
  }

}
