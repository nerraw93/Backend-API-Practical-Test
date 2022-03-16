<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

  /**
   * Register the user to the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {
    $request->validate([
      'username' => 'required|string|max:10|alpha_dash|unique:users',
      'email' => 'required|email|unique:users',
      'password' => 'required|string'
    ]);

    $user = User::create([
      'username' => $request->username,
      'email' => $request->email,
      'password' => Hash::make($request->password)
    ]);

    if (!$user->save()) {
      return response()->json(['error' => 'Invalid Request.'], 400);
    }

    return response()->json([
      'message' => 'User Successfully Created.',
    ], 201);
  }

  /**
   * Log the user into the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    $request->validate([
      'username' => 'required|string',
      'password' => 'required|string',
    ]);

    $credentials = request(['username', 'password']);

    if (!auth()->attempt($credentials)) {
      return response()->json([
        'message' => 'Please enter the correct username and password.'
      ], 401);
    }

    $user = $request->user();
    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json([
      'access_token' => $token,
      'token_type' => 'Bearer',
    ]);
  }

  /**
   * Log the user out to the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();
    return response()->json([
      'message' => 'User Successfully Logged-out.'
    ], 200);
  }

  /**
   * Retrieve the authenticated user's profile.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function me(Request $request)
  {
    $user = $request->user();
    $user->tweets;

    return response()->json($user, 200);
  }

  /**
   * Retrieve someone's profile.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function someone(Request $request, $id)
  {
    if ($id == $request->user()->id) {
      return response(null, 409);
    }

    $someone = User::find($id);

    if (empty($someone)) {
      return response()->json(['message' => "This user doesn't exist."], 404);
    }

    $someone->tweets;
    return response()->json($someone, 200);
  }

  /**
   * Follow a user's profile.
   *
   * @param  $id
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function follow(Request $request, $id)
  {
    $request->user()->following()->attach($id);
    return response()->json(['message' => 'You have followed user @' . User::find($id)->username . '.'], 200);
  }

  /**
   * Unfollow a user's profile.
   *
   * @param  $id
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function unfollow(Request $request, $id)
  {
    $request->user()->following()->detach($id);
    return response()->json(['message' => 'You have unfollowed user @' . User::find($id)->username . '.'], 200);
  }

  /**
   * Get all user's following list.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function following(Request $request)
  {
    return response()->json($request->user()->following()->get(), 200);
  }

  /**
   * Get all user's followers list.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function followers(Request $request)
  {
    return response()->json($request->user()->followers()->get(), 200);
  }
}
