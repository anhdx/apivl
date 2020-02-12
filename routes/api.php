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
Route::group(['prefix'=>'admin'], function(){
	// Route::get('/get-list-user','testApiController@index');
	// Route::get('/get-user-byId/{id}','testApiController@show');
	// Route::delete('/delete-user/{id}','testApiController@destroy');
	// Route::put('update-user/{id}','testApiController@update');
	// Route::patch('updateUserById/{id}','testApiController@updatePatch');
	// Route::post('createUser','testApiController@store');
	Route::get('sort/users/','testApiController@orderByUser');
	Route::get('search/users/','testApiController@searchApi');
	Route::match('patch','/users/{users}','testApiController@updatePatch');
	Route::apiResource('/users','testApiController');

	
});



