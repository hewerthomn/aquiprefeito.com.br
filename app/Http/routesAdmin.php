<?php
/**
 * Routes Admin
 */

Route::group(['prefix' => 'admin'], function() {

	Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'Admin\AdminController@dashboard']);
	Route::get('profile', ['as' => 'admin.profile', 'uses' => 'Admin\AdminController@profile']);

});
