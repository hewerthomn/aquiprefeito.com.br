<?php
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

	Route::get('issue/map', 'Api\IssueController@map');
	Route::get('issue/{id}/like', 'Api\IssueController@checkLike');
	Route::post('issue/{id}/like', 'Api\IssueController@saveLike');
	Route::get('issue/{id}/comment', 'Api\IssueController@getComments');
	Route::post('issue/{id}/comment', 'Api\IssueController@saveComment');

	Route::resource('issue', 'Api\IssueController',
									['only' => ['index', 'show']]);
});


require 'routesAdmin.php';
require 'routesPrefeitura.php';

Route::get('/{id?}', ['as' => 'home', 'uses' => 'HomeController@index']);
