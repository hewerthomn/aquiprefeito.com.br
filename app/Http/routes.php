<?php

Route::get('/', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'api'], function() {
	Route::resource('category', 'Api\CategoryController');
	Route::resource('issue', 'Api\IssueController');
});
