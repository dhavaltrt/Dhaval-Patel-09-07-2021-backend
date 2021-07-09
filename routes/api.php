<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

use Illuminate\Http\Request;

/* Auth Routes */
Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function () {
    Route::post('login', 'AuthController@login');
});
/* End of Auth Routes */

// Routes for user
Route::group(['middleware' => ['auth:api'] ], function () {
	Route::group(['prefix' => 'user', 'namespace' => 'Api'], function() {
    Route::get('/', 'AuthController@getUser');
    Route::get('/all', 'AuthController@getUsers');
    Route::get('logout', 'AuthController@logout');

    // Message routes
    Route::group(['prefix' => 'message'], function() {
      Route::get('/', 'MessageController@index');
      Route::post('/', 'MessageController@store');
      Route::delete('{id}', 'MessageController@destroy');
    });
  });
});
