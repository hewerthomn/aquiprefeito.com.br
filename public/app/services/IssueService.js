'use strict';
/**
 * Issue Service
 */
function IssueService($http, $localStorage, URL)
{
	this.get = function(id)
	{
		return $http.get(URL.API + 'issue/' + id);
	};

	this.getPoints = function()
	{
		return $http.get(URL.API + 'issue/map', {
			params: { city_name: $localStorage.city.name }
		});
	};

	this.getComments = function(id)
	{
		return $http.get(URL.API + 'issue/' + id + '/comment');
	};
};

angular
	.module('app')
	.service('Issue', IssueService);
