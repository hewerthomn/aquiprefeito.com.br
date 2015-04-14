<?php

Route::get('/', 'HomeController@index');

Route::get('upload', function() {
	return view('upload');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'api'], function() {
	Route::post('upload', 'Api\IssueController@upload');

	Route::resource('category', 'Api\CategoryController',
									['only' => ['index', 'show']]);

	Route::resource('issue', 'Api\IssueController',
									['only' => ['index', 'show']]);

	Route::get('issue/{id}/like', 'Api\IssueController@checkLike');
	Route::post('issue/{id}/like', 'Api\IssueController@saveLike');
});
