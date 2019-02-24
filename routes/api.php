<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
   
// });
Route::group(['prefix'=>'/auth'], function(){
	Route::post('login', 'Authcontroller@login');
	Route::post('register', 'Authcontroller@register');
	Route::delete('logout', 'Authcontroller@logout')->middleware('auth:api');
});
Route::get('/user', 'Authcontroller@details')->middleware('auth:api');