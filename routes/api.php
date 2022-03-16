<?php

use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
  Route::post('/register', [UserController::class, 'register']);
  Route::post('/login', [UserController::class, 'login']);
  Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
  Route::get('/me', [UserController::class, 'me']);
  Route::get('/me/followers', [UserController::class, 'followers']);
  Route::get('/me/following', [UserController::class, 'following']);
  Route::get('/{id}', [UserController::class, 'someone']);
  Route::post('/{id}/follow', [UserController::class, 'follow']);
  Route::post('/{id}/unfollow', [UserController::class, 'unfollow']);
});

Route::group(['prefix' => 'tweets', 'middleware' => 'auth:sanctum'], function () {
  Route::post('/create', [TweetController::class, 'create']);
  Route::post('/update/{id}', [TweetController::class, 'update']);
  Route::post('/delete/{id}', [TweetController::class, 'delete']);
  Route::get('/view/{id}', [TweetController::class, 'view']);
});
