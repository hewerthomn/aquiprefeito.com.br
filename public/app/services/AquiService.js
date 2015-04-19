'use strict';
/**
 * Aqui Service
 */
function AquiService($localStorage, Map, Geocoder) {

	this.init = function()
	{
		$localStorage.$default({
			city: {
				name: '...',
				lonlat: {
					lon: -5801876.194150391,
					lat: -1027313.6600097648
				}
			}
		});
	};

	this.storage = function()
	{
		return $localStorage;
	};

	this.getPlaceInfo = function(lonlat)
	{
		lonlat = Map.transform(lonlat, 'EPSG:900913', 'EPSG:4326');

		Geocoder.getPlaceInfo(lonlat)
			.success(function(response) {
				if(response.hasOwnProperty('results'))
				{
					if(response.results.length > 0)
					{
						var city = {
							lonlat: lonlat,
							name: response.results[0].address_components[4].long_name
						};
						$localStorage.city = city;
					}
					else
					{
						console.log('ZERO RESULTS :D');
					}
				}
			}, function(err) {
				alert(JSON.stringify(err));
			});
	};
};

angular
	.module('app')
	.service('Aqui', AquiService);
