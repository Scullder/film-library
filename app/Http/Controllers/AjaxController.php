<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function addComment(Request $request)
    {
      $login = Auth::user()->login;
      $reviewText = htmlspecialchars($request->comment);
      if($reviewText != '')
      {
        $token = bin2hex(random_bytes(16));
        DB::insert("insert into reviews(login, review, review_token, film_id)
                    values(?, ?, ?, ?)", ["$login", "$reviewText", "$token", $request->film_id]);
        return json_encode(['token' => $token, 'review' => $reviewText]);
      }
      return false;
    }

    public function loadComment(Request $request)
    {
      $tokensString = implode(',', $request->tokens);
      //$tokensSelectQuery = 'select login, review, review_token as token from reviews where review_token not in(?)';
      //$tokensSelected = DB::select('select login, review, review_token as token from reviews
        //                            where review_token not in("47d28488fc7d94c8c0f878466ceb2935")');

      $tokensSelected = DB::select('select login, review, review_token as token from reviews
                                  where review_token not in(?) and film_id = ?', [$tokensString, $request->film_id]);

      // Response
      $tokens = [];
      $reviews = [];
      foreach($tokensSelected as $obj)
      {
        $tokens[] = $obj->token;
        $reviews[] = $obj->review;
      }

      return json_encode(array_combine($tokens, $reviews));

      // select review from reviews order by id desc limit 1
    }
}
