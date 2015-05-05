<?php
/**
 * Routes Admin
 */

Route::group(['prefix' => 'admin'], function() {

	Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'Admin\AdminController@dashboard']);
	Route::get('profile', ['as' => 'admin.profile', 'uses' => 'Admin\AdminController@profile']);
	Route::post('profile', ['as' => 'admin.profile.edit', 'uses' => 'Admin\AdminController@profileUpdate']);
	Route::post('changePassword', ['as' => 'admin.changePassword', 'uses' => 'Admin\AdminController@changePassword']);

	Route::controllers([
		'issue' => 'Admin\IssueController'
	]);
});
