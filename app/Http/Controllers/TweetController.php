<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{

  /**
   * Create a tweet.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $request->validate([
      'content' => 'required',
      'file' => 'required|file'
    ]);

    $request->user()->tweets()->create([
      'content' => $request->content,
      'file' => $request->file('file')->store('files')
    ]);

    return response()->json(['message' => 'Tweet Successfully Created.'], 201);
  }

  /**
   * Update a tweet.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'content' => 'required',
      'file' => 'required|file'
    ]);

    $request->user()->tweets()
      ->where('id', $id)
      ->update([
        'content' => $request->content,
        'file' => $request->file('file')->store('files')
      ]);

    return response()->json(['message' => 'Tweet Successfully Updated.'], 200);
  }

  /**
   * Delete a tweet.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function delete(Request $request, $id)
  {
    $request->user()->tweets()
      ->where('id', $id)
      ->delete();

    return response()->json(['message' => 'Tweet Successfully Deleted.'], 200);
  }

  /**
   * View a tweet.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function view(Request $request, $id)
  {
    $tweet = $request->user()->tweets()
      ->where('id', $id)
      ->first();

    if (empty($tweet)) {
      return response()->json(['message' => "Tweet Doesn't Exist."], 404);
    }

    return response()->json(['tweet' => $tweet], 200);
  }
}
