'use strict';
/**
 * App Routes
 */
function routeConfig($routeProvider) {

	$routeProvider
		.when('/', {
			controller: 'HomeController',
			templateUrl: 'app/components/home/home.html'
		})
		.otherwise({
			redirect: '/'
		});
};

angular
	.module('app')
	.config(routeConfig);
