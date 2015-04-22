'use strict';
/**
 * Home Controller
 */
function HomeController($scope, $routeParams, $window, $modal, focus, Aqui, Issue, Map) {

	/*
	 * Private metodos
	 */
	function _init()
	{
		$scope.$storage = Aqui.storage();
		$scope.loading = {
			issue: false,
			points: false
		};

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

		_loadIssue();

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
		$scope.loading.points = true;

		Issue.getPoints()
			.success(function(points) {
				$scope.loading.points = false;
				Map.addPoints(points, { transformTo: 'EPSG:4326' });
			})
			.error(function(err) {
				$scope.loading.points = false;
			});
	};

	function _getIssue(id)
	{
		$scope.loading.issue = true;

		Issue.get(id)
			.success(function(issue) {
				$scope.loading.issue = false;
				_modalIssue(issue);
			})
			.error(function(err) {
				$scope.loading.issue = false;
				console.error(err)
			});
	};

	function _loadIssue()
	{
		if($routeParams.hasOwnProperty('id'))
		{
			_getIssue($routeParams.id);
		}
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
		_getIssue(feature.data.id);
	};

	_init();
};

angular
	.module('app')
	.controller('HomeController', HomeController);
