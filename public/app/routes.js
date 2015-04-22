'use strict';
/**
 * App Routes
 */
function routeConfig($routeProvider) {

	$routeProvider
		.when('/issue-:id', {
			controller: 'HomeController',
			templateUrl: 'app/components/home/home.html'
		})
		.when('/', {
			controller: 'HomeController',
			templateUrl: 'app/components/home/home.html'
		})
		.otherwise({
			redirectTo: '/'
		});
};

angular
	.module('app')
	.config(routeConfig);
