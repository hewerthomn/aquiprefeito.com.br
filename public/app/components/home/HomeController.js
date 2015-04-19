'use strict';
/**
 * Home Controller
 */
function HomeController($scope, $window, Map) {

	function _init()
	{
		Map.init({
			id: 'map',
			startZoom: 4,
			startLonlat: {
				lon: -5801876.194150391,
				lat: -1027313.6600097648,
			},
			onSelectPoint: _onSelectPoint
		});

		angular.element($window).bind('resize', function() { Map.fixMapHeight(); });

		console.log('HomeController initied :D');
	};

	function _onSelectPoint(feature)
	{
		console.log('feature data', feature.data);
	};

	_init();
};

angular
	.module('app')
	.controller('HomeController', HomeController);
