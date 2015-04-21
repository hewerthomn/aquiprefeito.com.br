'use strict';
/**
 * Modal Issue Controller
 */
function ModalIssueController($scope, $modalInstance, Issue, URL)
{
	function _init()
	{
		$scope.comments = [];

		Issue.getComments($scope.issue.id)
			.success(function(comments) {
				$scope.comments = comments;
			});
	};

	$scope.photo = function()
	{
		return URL.SITE + 'img/issues/big/' + $scope.issue.photo;
	};

	$scope.avatar = function(facebook_id)
	{
		facebook_id = facebook_id || $scope.issue.facebook_id;
		return 'https://graph.facebook.com/' + facebook_id  + '/picture';
	};

	$scope.cancel = function()
	{
		$modalInstance.dismiss('cancel');
	};

	_init();
};

angular
	.module('app')
	.controller('ModalIssueController', ModalIssueController);
