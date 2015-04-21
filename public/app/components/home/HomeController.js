'use strict';
/**
 * Home Controller
 */
function HomeController($scope, $window, focus, Aqui, Issue, Map) {

	/*
	 * Private metodos
	 */
	function _init()
	{
		$scope.$storage = Aqui.storage();

		Map.init({
			id: 'map',
			startZoom: 4,
			startLonlat: {
				lon: -5801876.194150391,
				lat: -1027313.6600097648,
			},
			onSelectPoint: _onSelectPoint
		});

		_getPosition();
		_getPoints();

		angular.element($window).bind('resize', function() { Map.fixMapHeight(); });
	};

	function _getPosition()
	{
		Map.getPosition(function(lonlat) {
			Map.setCenterMap(lonlat, 14);
			Aqui.getPlaceInfo(lonlat);

		}, function(err) {
			console.log(err);
		}, function() {
			// always
		});
	};

	function _getPoints()
	{
		Issue.getPoints()
			.success(function(points) {
				Map.addPoints(points, { transformTo: 'EPSG:4326' });
			});
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
