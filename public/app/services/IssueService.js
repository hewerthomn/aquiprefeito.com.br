'use strict';
/**
 * Issue Service
 */
function IssueService($http, $localStorage, URL)
{
	this.getPoints = function()
	{
		return $http.get(URL.API + 'issue/map', {
			params: { city_name: $localStorage.city.name }
		});
	}
};

angular
	.module('app')
	.service('Issue', IssueService);
