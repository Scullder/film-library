<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TakeFilmMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      $inputName = $request->filmName;
      $correctName = str_replace([' ', ':'], '-', $inputName);
      if($inputName != $correctName)
      {
        return redirect()->route('takeFilm', ['filmName' => $correctName]);
      }
      return $next($request);
    }
}
