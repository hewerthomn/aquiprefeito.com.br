'use strict';
/**
 * Home Controller
 */
function HomeController($scope) {

	function _init()
	{
		console.log('HomeController initied :D');
	};

	_init();
};

angular
	.module('app')
	.controller('HomeController', HomeController);
