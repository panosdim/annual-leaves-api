<?php

use App\User;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->put('/user/{user}', function (Request $request, User $user) {
    // check if currently authenticated user is trying to update himself
    if ($request->user()->id != $user->id) {
        return response()->json(['error' => 'You can only edit yourself.'], 403);
    }

    $user->update($request->only(['name', 'total_leaves']));
    return $user;
});
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::apiResource('leaves', 'LeaveController');
