'use strict';
/**
 * Home Controller
 */
function HomeController($scope, $window, $modal, focus, Aqui, Issue, Map) {

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

	function _modalIssue(issue)
	{
		$scope.issue = issue;

		$scope.modalIssue = $modal.open({
			size: 'lg',
			scope: $scope,
			controller: 'ModalIssueController',
			templateUrl: 'app/components/issue/modal-issue.html'
		});
	};

	function _onSelectPoint(feature)
	{
		Issue.get(feature.data.id)
			.success(function(issue) {
				_modalIssue(issue);
			})
			.error(function(err) {
				console.error(err)
			});
	};

	_init();
};

angular
	.module('app')
	.controller('HomeController', HomeController);
