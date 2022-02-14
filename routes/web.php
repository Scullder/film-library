<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FilmsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AjaxController;


use App\Http\Middleware\Login;

use App\Models\FilmsModel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/
Route::get('/', function(){
  return redirect()->route('films');
});
Route::get('/films/{page?}', [FilmsController::class, 'ShowFilms'])->name('films');

Route::group(['prefix' => 'film'], function(){
  Route::get('/{filmName}', [FilmsController::class, 'TakeFilm'])->name('takeFilm');
  Route::post('/like', [UserController::class, 'Like'])->name('filmLike');
  Route::post('/watch', [UserController::class, 'Watch'])->name('filmWatch');
  Route::post('/list', [UserController::class, 'List'])->name('filmList');
});

// авторизация, регистрация пользователя
Route::get('/login', function(){
  return view('account.login');
})->name('loginView');

Route::get('/registr', function(){
  return view('account.registr');
})->name('registrView');

Route::middleware('login')->group(function(){
  Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
  Route::get('/profile/{action?}/{page?}', [ProfileController::class, 'profile'])->name('profile');
  Route::post('/profile/rating', [UserController::class, 'rating'])->name('newRate');
});

Route::post('/login/submit', [LoginController::class, 'login'])->name('login');
Route::post('/registr/submit', [LoginController::class, 'registr'])->name('registr');


Route::post('/ajax/add', [AjaxController::class, 'addComment']);
Route::post('/ajax/load', [AjaxController::class, 'loadComment']);
