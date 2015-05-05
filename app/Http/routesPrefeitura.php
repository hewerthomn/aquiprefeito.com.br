<?php
/**
 * Routes Prefeitura
 */

Route::group(['prefix' => 'prefeitura', 'middleware' => 'auth'], function() {

	Route::get('/', ['as' => 'prefeitura.dashboard', 'uses' => 'Mayor\IssueController@index']);
	Route::get('select/{id?}', ['as' => 'prefeitura.select', 'uses' => 'Mayor\IssueController@getSelect']);

	Route::controllers([
		'issue' => 'Mayor\IssueController'
	]);
});

